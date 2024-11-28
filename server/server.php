<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Protobuf\Timestamp;
use Spiral\RoadRunner\GRPC\Exception\NotFoundException;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\Worker;
use Google\Protobuf\GPBEmpty;
use Article\ArticleServiceInterface;
use Article\GetArticlesResponse;
use Article\DeleteArticleRequest;
use Article\DeleteArticleResponse;
use Article\Article;
use User\UserServiceInterface;
use User\GetUsersResponse;
use User\DeleteUserRequest;
use User\DeleteUserResponse;
use User\User;

class ArticleStore
{
    private static array $articles = [];
    private static int $nextId = 1;

    public static function create(Article $article): Article
    {
        $article->setId(self::$nextId++);
        $article->setCreatedAt(new Timestamp([
            'seconds' => time()
        ]));
        self::$articles[$article->getId()] = $article;
        return $article;
    }

    public static function update(Article $article): ?Article
    {
        if (!isset(self::$articles[$article->getId()])) {
            return null;
        }
        // Preserve creation timestamp
        $article->setCreatedAt(self::$articles[$article->getId()]->getCreatedAt());
        self::$articles[$article->getId()] = $article;
        return $article;
    }

    public static function delete(int $id): bool
    {
        if (!isset(self::$articles[$id])) {
            return false;
        }
        unset(self::$articles[$id]);
        return true;
    }

    public static function get(int $id): ?Article
    {
        return self::$articles[$id] ?? null;
    }

    public static function getAll(): array
 {
        return array_values(self::$articles);
    }
}


class UserStorage
{
    private static array $users = [];
    private static int $nextId = 1;

    public static function create(User $user): User
    {
        $user->setId(self::$nextId++);
        self::$users[$user->getId()] = $user;
        return $user;
    }

    public static function update(User $user): ?User
    {
        if (!isset(self::$users[$user->getId()])) {
            return null;
        }
        self::$users[$user->getId()] = $user;
        return $user;
    }

    public static function delete(int $id): bool
    {
        if (!isset(self::$users[$id])) {
            return false;
        }
        unset(self::$users[$id]);
        return true;
    }

    public static function get(int $id): ?User
    {
        return self::$users[$id] ?? null;
    }

    public static function getAll(): array
    {
        return array_values(self::$users);
    }
}

// Article Service Implementation
class ArticleServiceImpl implements ArticleServiceInterface
{
    public function GetArticles(ContextInterface $ctx, GPBEmpty $in): GetArticlesResponse
    {
        $response = new GetArticlesResponse();
        $response->setArticles(ArticleStore::getAll());
        return $response;
    }

    public function CreateArticle(ContextInterface $ctx, Article $in): Article
    {
        return ArticleStore::create($in);
    }

    public function UpdateArticle(ContextInterface $ctx, Article $in): Article
    {
        $updated = ArticleStore::update($in);
        if ($updated === null) {
            throw new NotFoundException('Article not found');
        }
        return $updated;
    }

    public function DeleteArticle(ContextInterface $ctx, DeleteArticleRequest $in): DeleteArticleResponse
    {
        $success = ArticleStore::delete($in->getId());
        $response = new DeleteArticleResponse();
        $response->setSuccess($success);
        if (!$success) {
            throw new NotFoundException('Article not found');
        }
        return $response;
    }
}

// User Service Implementation
class UserServiceImpl implements UserServiceInterface
{
    public function GetUsers(ContextInterface $ctx, GPBEmpty $in): GetUsersResponse
    {
        $response = new GetUsersResponse();
        $response->setUsers(UserStorage::getAll());
        return $response;
    }

    public function CreateUser(ContextInterface $ctx, User $in): User
    {
        return UserStorage::create($in);
    }

    public function UpdateUser(ContextInterface $ctx, User $in): User
    {
        $updated = UserStorage::update($in);
        if ($updated === null) {
            throw new NotFoundException('User not found');
        }
        return $updated;
    }

    public function DeleteUser(ContextInterface $ctx, DeleteUserRequest $in): DeleteUserResponse
    {
        $success = UserStorage::delete($in->getId());
        $response = new DeleteUserResponse();
        $response->setSuccess($success);
        if (!$success) {
            throw new NotFoundException('User not found');
        }
        return $response;
    }
}


$server = new Server();

$server->registerService(UserServiceInterface::class, new UserServiceImpl());
$server->registerService(ArticleServiceInterface::class, new ArticleServiceImpl());

$server->serve(Worker::create());
