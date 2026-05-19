<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $initialCode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $expectedOutput = null;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    /**
     * @var Collection<int, UserProgress>
     */
    #[ORM\OneToMany(targetEntity: UserProgress::class, mappedBy: 'lesson', orphanRemoval: true)]
    private Collection $userProgresses;

    public function __construct()
    {
        $this->userProgresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getInitialCode(): ?string
    {
        return $this->initialCode;
    }

    public function setInitialCode(?string $initialCode): static
    {
        $this->initialCode = $initialCode;

        return $this;
    }

    public function getExpectedOutput(): ?string
    {
        return $this->expectedOutput;
    }

    public function setExpectedOutput(?string $expectedOutput): static
    {
        $this->expectedOutput = $expectedOutput;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, UserProgress>
     */
    public function getUserProgresses(): Collection
    {
        return $this->userProgresses;
    }

    public function addUserProgress(UserProgress $userProgress): static
    {
        if (!$this->userProgresses->contains($userProgress)) {
            $this->userProgresses->add($userProgress);
            $userProgress->setLesson($this);
        }

        return $this;
    }

    public function removeUserProgress(UserProgress $userProgress): static
    {
        if ($this->userProgresses->removeElement($userProgress)) {
            // set the owning side to null (unless already changed)
            if ($userProgress->getLesson() === $this) {
                $userProgress->setLesson(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? 'Lección sin nombre';
    }
}
