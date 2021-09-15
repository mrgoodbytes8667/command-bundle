<?php


namespace Bytes\CommandBundle\Tests\fixtures\Command;


/**
 *
 */
class SampleNeedsOutputSuccessOnlyCommand extends SampleSuccessOnlyCommand
{
    /**
     * @var bool
     */
    protected $needsOutput = true;
}