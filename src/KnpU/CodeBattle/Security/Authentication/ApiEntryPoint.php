<?php

namespace KnpU\CodeBattle\Security\Authentication;

use KnpU\CodeBattle\Api\ApiProblem;
use KnpU\CodeBattle\Api\ApiProblemResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Translation\Translator;

/**
 * Determines the Response that should be back if:
 *
 *  A) There is an authentication error
 *  B) The request requires authentication, but none was provided
 */
class ApiEntryPoint implements AuthenticationEntryPointInterface
{
    private $translator;
    private $apiProblemResponse;

    public function __construct(Translator $translator, ApiProblemResponseFactory $apiProblemResponse)
    {
        $this->translator = $translator;
        $this->apiProblemResponse = $apiProblemResponse;
    }

    /**
     * Starts the authentication scheme.
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $message = $this->getMessage($authException);

        $apiProblem = new ApiProblem(401, ApiProblem::TYPE_AUTHENTICATION_ERROR);
        $apiProblem->set('detail', $message);

        $response = $this->apiProblemResponse->createResponse($apiProblem);

        return $response;
    }

    /**
     * Gets the message from the specific AuthenticationException and then
     * translates it. The translation process allows us to customize the
     * messages we want - see the translations/en.yml file.
     */
    private function getMessage(AuthenticationException $authException = null)
    {
        $key = $authException ? $authException->getMessageKey() : 'authentication_required';
        $parameters = $authException ? $authException->getMessageData() : array();

        return $this->translator->trans($key, $parameters);
    }
}
