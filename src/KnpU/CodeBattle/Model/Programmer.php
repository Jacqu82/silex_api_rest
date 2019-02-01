<?php

namespace KnpU\CodeBattle\Model;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *          "api_programmers_show",
 *          parameters = {
 *              "nickname" = "expr(object.nickname)"
 *          }
 *      )
 * )
 * @Hateoas\Relation(
 *     "battles",
 *     href = @Hateoas\Route(
 *          "api_programmers_battles_list",
 *          parameters = {
 *              "nickname" = "expr(object.nickname)"
 *          }
 *      )
 * )
 */
class Programmer
{

    /* All public properties are persisted */
    public $id;

    /**
     * @Assert\NotBlank(message="Enter a clever nickname!")
     * @Serializer\Expose()
     */
    public $nickname;

    /**
     * Number of an avatar, from 1-6
     *
     * @var integer
     * @Serializer\Expose()
     */
    public $avatarNumber;

    /**
     * @Serializer\Expose()
     */
    public $tagLine;

    public $userId;

    /**
     * @Serializer\Expose()
     */
    public $powerLevel = 0;

    public function __construct($nickname = null, $avatarNumber = null)
    {
        $this->nickname = $nickname;
        $this->avatarNumber = $avatarNumber;
    }


}
