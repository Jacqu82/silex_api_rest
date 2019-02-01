<?php

namespace KnpU\CodeBattle\Model;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *     "programmer",
 *     href = @Hateoas\Route(
 *          "api_programmers_show",
 *          parameters = {
 *              "nickname" = "expr(object.programmer.nickname)"
 *          }
 *      ),
 *     embedded="expr(object.programmer)"
 * )
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "api_battle_show",
 *          parameters = {
 *              "id" = "expr(object.id)"
 *          }
 *      )
 * )
 */
class Battle
{
    /* All public properties are persisted */

    /**
     * @Serializer\Expose()
     */
    public $id;

    /**
     * @var Programmer
     */
    public $programmer;

    /**
     * @var Project
     */
    public $project;

    /**
     * @Serializer\Expose()
     */
    public $didProgrammerWin;

    /**
     * @Serializer\Expose()
     */
    public $foughtAt;

    /**
     * @Serializer\Expose()
     */
    public $notes;

//    /**
//     * @Serializer\VirtualProperty()
//     */
//    public function getProgrammerUri()
//    {
//        return '/api/programmers/' . $this->programmer->nickname;
//    }
}
