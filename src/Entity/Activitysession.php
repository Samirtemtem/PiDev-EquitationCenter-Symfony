<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "activitysession", indexes: [new ORM\Index(name: "ActivityID", columns: ["ActivityID"])])]
#[ORM\Entity]
class Activitysession
{
    #[ORM\Column(name: "ID", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private ?int $id = null;

    #[ORM\Column(name: "Weekday", type: "integer", nullable: true, options: ["default" => null])]
    private ?int $weekday = null;

    #[ORM\Column(name: "StartTime", type: "time", nullable: true, options: ["default" => null])]
    private ?\DateTimeInterface $starttime = null;

    #[ORM\Column(name: "EndTime", type: "time", nullable: true, options: ["default" => null])]
    private ?\DateTimeInterface $endtime = null;

    #[ORM\ManyToOne(targetEntity: Activity::class)]
    #[ORM\JoinColumn(name: "ActivityID", referencedColumnName: "id")]
    private ?Activity $activityid = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekday(): ?int
    {
        return $this->weekday;
    }

    public function setWeekday(?int $weekday): self
    {
        $this->weekday = $weekday;
        return $this;
    }

    public function getStarttime(): ?\DateTimeInterface
    {
        return $this->starttime;
    }

    public function setStarttime(?\DateTimeInterface $starttime): self
    {
        $this->starttime = $starttime;
        return $this;
    }

    public function getEndtime(): ?\DateTimeInterface
    {
        return $this->endtime;
    }

    public function setEndtime(?\DateTimeInterface $endtime): self
    {
        $this->endtime = $endtime;
        return $this;
    }

    public function getActivityid(): ?Activity
    {
        return $this->activityid;
    }

    public function setActivityid(?Activity $activityid): self
    {
        $this->activityid = $activityid;
        return $this;
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'weekday' => $this->getWeekday(),
            'starttime' => $this->getStarttime() ? $this->getStarttime()->format('H:i:s') : null,
            'endtime' => $this->getEndtime() ? $this->getEndtime()->format('H:i:s') : null,
            'activityid' => $this->getActivityid() ? $this->getActivityid()->getId() : null,
        ];
    }
    public function getDurationInHours(): ?float
    {
        if ($this->starttime && $this->endtime) {
            $start = $this->starttime->getTimestamp();
            $end = $this->endtime->getTimestamp();
            $durationInSeconds = $end - $start;
            $durationInHours = $durationInSeconds / 3600; // 3600 seconds in an hour
            return $durationInHours;
        }

        return null;
    }
}
