<?php
# Generated by the protocol buffer compiler (roadrunner-server/grpc). DO NOT EDIT!
# source: article.proto

namespace Article;

use Spiral\RoadRunner\GRPC;

interface ArticleServiceInterface extends GRPC\ServiceInterface
{
    // GRPC specific service name.
    public const NAME = "article.ArticleService";

    /**
    * @param GRPC\ContextInterface $ctx
    * @param \Google\Protobuf\GPBEmpty $in
    * @return GetArticlesResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function GetArticles(GRPC\ContextInterface $ctx, \Google\Protobuf\GPBEmpty $in): GetArticlesResponse;

    /**
    * @param GRPC\ContextInterface $ctx
    * @param Article $in
    * @return Article
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CreateArticle(GRPC\ContextInterface $ctx, Article $in): Article;

    /**
    * @param GRPC\ContextInterface $ctx
    * @param Article $in
    * @return Article
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function UpdateArticle(GRPC\ContextInterface $ctx, Article $in): Article;

    /**
    * @param GRPC\ContextInterface $ctx
    * @param DeleteArticleRequest $in
    * @return DeleteArticleResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function DeleteArticle(GRPC\ContextInterface $ctx, DeleteArticleRequest $in): DeleteArticleResponse;
}
