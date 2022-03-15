<?php

return [
    'general' => [
        'localizationOverview' => 'Localization overview',
        'from' => 'From',
        'to' => 'To',
        'overview' => 'Overview',
    ],
    'userManagement' => [
        'title'          => 'User',
        'title_singular' => 'User',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'categories'               => 'Categories',
            'categories_helper'        => '',
            'languages'                => 'Languages',
            'languages_helper'         => '',
            'userTranslations'         => 'Translations',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'projectManagement' => [
        'title'          => 'Project',
        'title_singular' => 'Project',
    ],
    'project'        => [
        'title'          => 'Projects',
        'title_singular' => 'Project',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Name',
            'name_helper'        => '',
            'description'        => 'Description',
            'description_helper' => '',
            'author'             => 'Author',
            'author_helper'      => '',
            'languages'          => 'Languages',
            'languages_helper'   => '',
            'categories'         => 'Categories',
            'categories_helper'  => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'category'        => [
        'title'          => 'Categories',
        'title_singular' => 'Category',
        'translations'   => 'Translations',
        'fields'         => [
            'name'               => 'Name',
            'name_helper'        => '',
            'description'        => 'Description',
            'description_helper' => '',
            'project'            => 'Project',
            'project_helper'     => '',
            'icon'               => 'Icon',
            'icon_helper'        => '',
            'phrases'            => 'Phrases',
            'phrases_helper'     => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'language'        => [
        'title'          => 'Languages',
        'title_singular' => 'Language',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => '',
            'title'                 => 'Title',
            'title_helper'          => '',
            'iso_code'              => 'ISO Code',
            'iso_code_helper'       => '',
            'local_name'            => 'Local Name',
            'local_name_helper'     => '',
            'text_direction'        => 'Text Direction',
            'text_direction_helper' => '',
            'is_primary'            => 'Is Primary',
            'is_primary_helper'     => '',
            'active'                => 'Active',
            'active_helper'         => '',
            'created_at'            => 'Created at',
            'created_at_helper'     => '',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => '',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => '',
        ],
    ],
    'translationManagement' => [
        'title'          => 'Translation',
        'title_singular' => 'Translation',
    ],
    'phrase'        => [
        'title'          => 'Phrases',
        'title_singular' => 'Phrase',
        'fields'         => [
            'id'                          => 'ID',
            'id_helper'                   => '',
            'base_id'                     => 'Base ID',
            'base_id_helper'              => '',
            'phrase'                      => 'Phrase',
            'phrase_helper'               => '',
            'category_name'               => 'Category',
            'category_name_helper'        => '',
            'translations'                => 'Translations',
            'translations_helper'         => '',
            'created_at'                  => 'Created at',
            'created_at_helper'           => '',
            'updated_at'                  => 'Updated at',
            'updated_at_helper'           => '',
            'deleted_at'                  => 'Deleted at',
            'deleted_at_helper'           => '',
        ],
    ],
    'translation'        => [
        'title'          => 'Translations',
        'title_singular' => 'Translation',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'translation'        => 'Translation',
            'translation_helper' => '',
            'phrase'             => 'Phrase',
            'phrase_helper'      => '',
            'language'           => 'Language',
            'language_helper'    => '',
            'author'             => 'Author',
            'author_helper'      => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
];
