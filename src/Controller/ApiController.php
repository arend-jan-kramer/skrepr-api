<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Repository\MemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    private MemoRepository $memoRepository;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(
        MemoRepository $memoRepository,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->memoRepository = $memoRepository;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    #[Route('/api/memos', name: 'phoneNumbers', methods: ['GET'])]
    public function phoneNumbers(): JsonResponse
    {
        return new JsonResponse([
            'error' => false,
            'results' => $this->memoRepository->findAll()
        ]);
    }

    #[Route('/api/memo/{id}', name: 'getPhoneNumber', methods: ['GET'])]
    public function phoneNumber(int $id): JsonResponse
    {
        $memo = $this->memoRepository->find($id);

        if (null === $memo) {
            return new JsonResponse([
                'error' => false,
                'message' => 'Not found!'
            ]);
        }

        return new JsonResponse([
            'error' => false,
            'message' => $memo
        ]);
    }

    #[Route('/api/memo', name: 'createPhoneNumber', methods: ['POST'])]
    public function createPhoneNumber(Request $request): JsonResponse
    {
        if ('json' !== $request->getContentType()) {
            return new JsonResponse([
                'error' => true,
                'message' => 'invalid format json'
            ]);
        }

        try {
            $memo = $this->serializer->deserialize(
                $request->getContent(),
                Memo::class,
                'json', [
                    DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true,
                ]
            );

            $errors = $this->validator->validate($memo);

            if ($errors->count() > 0) {
                $errorMessage = [];
                foreach ($errors as $error) {
                    $errorMessage[] = $error->getMessage();
                }
                return new JsonResponse([
                    'error' => true,
                    'message' => $errorMessage
                ]);
            }
        } catch (PartialDenormalizationException $exception) {
            $errorMessage = ['Something go\'s wrong'];
            foreach ($exception->getErrors() as  $e) {
                if (!$e->canUseMessageForUser()) {
                    $errorMessage[] = sprintf(
                        'The value "%s" should be "%s" but got an "%s"',
                        $e->getPath(),
                        implode(', ', $e->getExpectedTypes()),
                        $e->getCurrentType()
                    );
                }
            }
            return new JsonResponse(['error' => true, 'message' => $errorMessage]);
        }

//        $this->memoRepository->save($memo);

        return new JsonResponse([
            'error' => false,
            'message' => $memo
        ]);
    }
}
