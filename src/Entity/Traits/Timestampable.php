<?php

namespace App\Entity\Traits;

/**
 *
 */
trait Timestampable
{
     /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"},)
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function updateTimestamps(){

        if($this->getCreateAt() === null){
            $this->setCreateAt(new \DateTimeImmutable);
        }

        $this->setUpdatedAt(new \DateTimeImmutable);
    }

}
