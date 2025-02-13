<?php

declare(strict_types=1);

namespace TomasVotruba\PhpFwTrends\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symplify\EasyHydrator\ArrayToValueObjectHydrator;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use TomasVotruba\PhpFwTrends\Exception\ShouldNotHappenException;
use TomasVotruba\PhpFwTrends\ValueObject\Option;
use TomasVotruba\PhpFwTrends\ValueObject\RouteName;
use TomasVotruba\PhpFwTrends\ValueObject\VendorData;

final class FrameworkController extends AbstractController
{
    public function __construct(
        private ParameterProvider $parameterProvider,
        private ArrayToValueObjectHydrator $arrayToValueObjectHydrator
    ) {
    }

    #[Route(path: 'framework/{frameworkName}', name: RouteName::FRAMEWORK)]
    public function __invoke(string $frameworkName): Response
    {
        $frameworkTrend = $this->matchFrameworkTrend($frameworkName);
        if ($frameworkTrend === []) {
            throw new ShouldNotHappenException($frameworkName);
        }

        /** @var VendorData $vendorData */
        $vendorData = $this->arrayToValueObjectHydrator->hydrateArray($frameworkTrend, VendorData::class);

        $titleFrameworkName = ucfirst($frameworkName);

        return $this->render('homepage/framework.twig', [
            'title' => $titleFrameworkName . ' Framework Trends',
            'framework_trend' => $vendorData,
        ]);
    }

    /**
     * @return mixed[]
     */
    private function matchFrameworkTrend(string $frameworkName): array
    {
        $phpFrameworkTrends = $this->parameterProvider->provideArrayParameter(Option::PHP_FRAMEWORK_TRENDS)['vendors'];

        foreach ($phpFrameworkTrends as $frameworkTrend) {
            /** @var VendorData $vendorData */
            $vendorData = $this->arrayToValueObjectHydrator->hydrateArray($frameworkTrend, VendorData::class);
            if ($vendorData->getVendorKey() === $frameworkName) {
                return $frameworkTrend;
            }
        }

        return [];
    }
}
