<?php

namespace KnpU\CodeBattle\Controller\Api;

use KnpU\CodeBattle\Controller\BaseController;
use KnpU\CodeBattle\Model\Programmer;
use KnpU\CodeBattle\Model\Project;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class BattleController extends BaseController
{
    protected function addRoutes(ControllerCollection $controllers)
    {
        $controllers->post('/api/battles', array($this, 'newAction'));
        $controllers->get('/api/battles/{id}', array($this, 'showAction'))
            ->bind('api_battle_show');
    }

    public function newAction(Request $request)
    {
        $this->enforceUserSecurity();

        $data = $this->decodeRequestBodyIntoParameters($request);

        $projectId = $data->get('projectId');
        $programmerId = $data->get('programmerId');

        /** @var Project $project */
        $project = $this->getProjectRepository()->find($projectId);
        /** @var Programmer $programmer */
        $programmer = $this->getProgrammerRepository()->find($programmerId);

        $errors = [];
        if (!$project) {
            $errors['projectId'] = 'Invalid or missing projectId';
        }
        if (!$programmer) {
            $errors['programmerId'] = 'Invalid or missing programmerId';
        }
        if ($errors) {
            $this->throwApiProblemValidationException($errors);
        }

        $battle = $this->getBattleManager()->battle($programmer, $project);

        $response = $this->createApiResponse($battle, 201);
        $url = $this->generateUrl('api_battle_show', ['id' => $battle->id]);
        $response->headers->set('Location', $url);

        return $response;
    }

    public function showAction($id)
    {
        $battle = $this->getBattleRepository()->find($id);
        if (!$battle) {
            $this->throw404(sprintf('No battle found for id %d!', $id));
        }

        $response = $this->createApiResponse($battle);
//        $response->headers->set('Content-Type', 'application/hal+json');

        return $response;
    }
}
