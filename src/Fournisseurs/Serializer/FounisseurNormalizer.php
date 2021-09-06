<?php

namespace App\Fournisseurs\Serializer;

use App\Fournisseurs\Documents\Fournisseur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FounisseurNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'FOURNISSEUR_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /** @param Fournisseur $object */
    public function normalize($object, $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $normalized = $this->normalizer->normalize($object, $format, $context);

        $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$object->getDomaineIri());

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $normalized['domaineIri'] = \json_decode($response->getContent(), true);
        }

        $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$object->getAdresseIri());

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $normalized['adresseIri'] = \json_decode($response->getContent(), true);
        }

        $normalized['contactIris'] = [];

        foreach ($object->getContactIris() as $contactIri) {
            $response = $this->httpClient->request('GET', 'http://api.erp.docker'.$contactIri);

            if (Response::HTTP_OK === $response->getStatusCode()) {
                $normalized['contactIris'][] = \json_decode($response->getContent(), true);
            } else {
                $normalized['contactIris'][] = $contactIri;
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

        return $data instanceof Fournisseur;
    }
}