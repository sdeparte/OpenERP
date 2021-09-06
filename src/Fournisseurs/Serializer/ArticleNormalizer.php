<?php

namespace App\Fournisseurs\Serializer;

use App\Fournisseurs\Documents\Article;
use App\Fournisseurs\Documents\Version;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'ARTICLE_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private DocumentManager $documentManager;

    private HttpClientInterface $httpClient;

    public function __construct(DocumentManager $documentManager, HttpClientInterface $httpClient)
    {
        $this->documentManager = $documentManager;
        $this->httpClient = $httpClient;
    }

    /** @param Article $object */
    public function normalize($object, $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        $normalized = $this->normalizer->normalize($object, $format, $context);
        /** @var Version $versionIri */
        foreach ($object->getVersionIris() as $versionKey => $versionIri) {
            var_dump(count($versionIri->getReferenceFournisseurIris()));
            $versionIri2 = $this->documentManager->getRepository(Version::class)->find($versionIri->getId());
            var_dump(count($versionIri2->getReferenceFournisseurIris()));
        }

        return $normalized;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        // Make sure we're not called twice
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return false;//$data instanceof Article;
    }
}