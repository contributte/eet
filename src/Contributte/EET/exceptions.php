<?php

namespace Contributte\EET;

interface EETException extends \Throwable
{
}

class UnexpectedValueException extends \UnexpectedValueException implements EETException
{
}
