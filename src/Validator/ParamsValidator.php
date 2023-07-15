<?php
namespace App\Validator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParamsValidator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateParameters(Request $request): array
    {
        $validator = $this->validator;
        $errors = [];

        $perPage = $request->query->get('per_page', 10);
        $page = $request->query->get('page', 1);
        $category = $request->query->get('category');
        $tags = $request->query->get('tags');
        $with = $request->query->get('with');
        $lang = $request->query->get('lang');
        $diffTime = $request->query->get('diff_time');

        $constraint = new Assert\Collection([
            'per_page' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'numeric']),
                new Assert\Positive(),
            ]),
            'page' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'numeric']),
                new Assert\Positive(),
            ]),
            'category' => new Assert\Optional([
                new Assert\Type(['type' => 'numeric']),
                new Assert\Positive(),
            ]),
            'tags' => new Assert\Optional([
                new Assert\Type(['type' => 'string']),
            ]),
            'with' => new Assert\Optional([
                new Assert\Type(['type' => 'string']),
            ]),
            'lang' => new Assert\Required([
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
            ]),
            'diff_time' => new Assert\Optional([
                new Assert\Type(['type' => 'numeric']),
                new Assert\Positive(),
            ]),
        ]);

        $parameters = [
            'per_page' => $perPage,
            'page' => $page,
            'category' => $category,
            'tags' => $tags,
            'with' => $with,
            'lang' => $lang,
            'diff_time' => $diffTime,
        ];

        $violations = $validator->validate($parameters, $constraint);

        if (count((array) $violations) > 0) {
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }

        return $errors;
    }

}