<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: user.proto

namespace GPBMetadata\User;

class User
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        $pool->internalAddGeneratedFile(
            "\x0A\xBF\x04\x0A\x0Auser.proto\x12\x04user\x1A\x1Bgoogle/protobuf/empty.proto\"-\x0A\x10GetUsersResponse\x12\x19\x0A\x05users\x18\x01 \x03(\x0B2\x0A.user.User\"/\x0A\x04User\x12\x0A\x0A\x02id\x18\x01 \x01(\x05\x12\x0C\x0A\x04name\x18\x02 \x01(\x09\x12\x0D\x0A\x05email\x18\x03 \x01(\x09\"\x1F\x0A\x11DeleteUserRequest\x12\x0A\x0A\x02id\x18\x01 \x01(\x05\"%\x0A\x12DeleteUserResponse\x12\x0F\x0A\x07success\x18\x01 \x01(\x082\xB2\x02\x0A\x0BUserService\x12M\x0A\x08GetUsers\x12\x16.google.protobuf.Empty\x1A\x16.user.GetUsersResponse\"\x11\x82\xD3\xE4\x93\x02\x0B\x12\x09/v1/users\x12:\x0A\x0ACreateUser\x12\x0A.user.User\x1A\x0A.user.User\"\x14\x82\xD3\xE4\x93\x02\x0E\"\x09/v1/users:\x01*\x12?\x0A\x0AUpdateUser\x12\x0A.user.User\x1A\x0A.user.User\"\x19\x82\xD3\xE4\x93\x02\x13\x1A\x0E/v1/users/{id}:\x01*\x12W\x0A\x0ADeleteUser\x12\x17.user.DeleteUserRequest\x1A\x18.user.DeleteUserResponse\"\x16\x82\xD3\xE4\x93\x02\x10*\x0E/v1/users/{id}B)Z\x0Dgateway/proto\xCA\x02\x04User\xE2\x02\x10GPBMetadata\\Userb\x06proto3"
        , true);

        static::$is_initialized = true;
    }
}

