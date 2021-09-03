<?php

namespace App\Fournisseurs\Serializer;

use App\Fournisseurs\Documents\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'ARTICLE_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /** @param Article $object */
    public function normalize($object, $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $normalized = $this->normalizer->normalize($object, $format, $context);

        $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$object->getSousEnsembleIri());

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $normalized['sousEnsembleIri'] = \json_decode($response->getContent(), true);
        }

        $normalized['versionIris'] = [];

        foreach ($object->getVersionIris() as $versionIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$versionIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['versionIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['versionIris'][] = $versionIri;
            }
        }

        return $normalized;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        // Make sure we're not called twice
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Article;
    }
}