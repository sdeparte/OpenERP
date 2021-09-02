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

        $normalized['couleurIris'] = [];

        foreach ($object->getCouleurIris() as $couleurIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$couleurIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['couleurIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['couleurIris'][] = $couleurIri;
            }
        }

        $normalized['matiereIris'] = [];

        foreach ($object->getMatiereIris() as $matiereIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$matiereIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['matiereIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['matiereIris'][] = $matiereIri;
            }
        }

        $normalized['planIris'] = [];

        foreach ($object->getPlanIris() as $planIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$planIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['planIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['planIris'][] = $planIri;
            }
        }

        $normalized['tarifIris'] = [];

        foreach ($object->getTarifIris() as $tarifIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$tarifIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['tarifIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['tarifIris'][] = $tarifIri;
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