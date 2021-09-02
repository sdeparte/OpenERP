<?php

namespace App\Fournisseurs\Serializer;

use App\Fournisseurs\Documents\SousEnsemble;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SousEnsembleNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'SOUS_ENSEMBLE_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /** @param SousEnsemble $object */
    public function normalize($object, $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $normalized = $this->normalizer->normalize($object, $format, $context);

        $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$object->getTypeIri());

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $normalized['typeIri'] = \json_decode($response->getContent(), true);
        }

        return $normalized;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        // Make sure we're not called twice
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof SousEnsemble;
    }
}