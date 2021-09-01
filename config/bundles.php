<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['microServices' => ['all' => true], 'envs' => ['dev' => true, 'test' => true]],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['microServices' => ['all' => true], 'envs' => ['dev' => true]],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['microServices' => ['all' => true], 'envs' => ['dev' => true]],
    Nelmio\CorsBundle\NelmioCorsBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['microServices' => ['all' => true], 'envs' => ['all' => true]],
    Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle::class => ['microServices' => ['Users' => true], 'envs' => ['all' => true]],
];
