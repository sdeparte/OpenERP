<?php

namespace App\Fournisseurs\Serializer;

use App\Fournisseurs\Documents\Version;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VersionNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'VERSION_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /** @param Version $object */
    public function normalize($object, $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $normalized = $this->normalizer->normalize($object, $format, $context);

        $normalized['referenceFournisseurIris'] = [];

        foreach ($object->getReferenceFournisseurIris() as $referenceFournisseurIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$referenceFournisseurIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['referenceFournisseurIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['referenceFournisseurIris'][] = $referenceFournisseurIri;
            }
        }

        $normalized['parametreIris'] = [];

        foreach ($object->getParametreIris() as $parametreIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$parametreIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['parametreIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['parametreIris'][] = $parametreIri;
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

        return $data instanceof Version;
    }
}