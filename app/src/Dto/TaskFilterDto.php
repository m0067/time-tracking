<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TaskFilterDto
{
    /**
     * @Assert\Date()
     */
    private ?string $from;

    /**
     * @Assert\Date()
     */
    private ?string $to;

    public function __construct(Request $request)
    {
        $this->from = $request->query->get('from');
        $this->to = $request->query->get('to');
    }

    public function getFrom(): ?string
    {
        return $this->from;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }
}