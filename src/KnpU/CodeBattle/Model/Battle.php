<?php

namespace KnpU\CodeBattle\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Battle
{
    /* All public properties are persisted */
    public $id;

    /**
     * @var Programmer
     */
    public $programmer;

    /**
     * @var Project
     */
    public $project;

    public $didProgrammerWin;

    public $foughtAt;

    public $notes;
}
