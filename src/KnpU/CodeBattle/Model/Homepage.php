<?php

namespace KnpU\CodeBattle\Model;

use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "api_homepage"
 *      ),
 *     attributes={"title": "The Api Homepage"}
 * )
 * @Hateoas\Relation(
 *     "programmers",
 *     href = @Hateoas\Route(
 *          "api_programmers_list"
 *      ),
 *     attributes={"title": "All of the programmers in the system :)"}
 * )
 */
class Homepage
{
    private $message = 'Welcome to the CodeBattles API! Look around at the _links to browse the API. And have a crazy-cool day.';
}
