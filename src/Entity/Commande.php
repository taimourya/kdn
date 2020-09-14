<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Template::class, inversedBy="commandes")
     */
    private $template;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $with_host;

    /**
     * @ORM\Column(type="boolean")
     */
    private $with_maintenance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $with_newsletter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientFirstname(): ?string
    {
        return $this->client_firstname;
    }

    public function setClientFirstname(string $client_firstname): self
    {
        $this->client_firstname = $client_firstname;

        return $this;
    }

    public function getClientLastname(): ?string
    {
        return $this->client_lastname;
    }

    public function setClientLastname(string $client_lastname): self
    {
        $this->client_lastname = $client_lastname;

        return $this;
    }

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWithHost(): ?bool
    {
        return $this->with_host;
    }

    public function setWithHost(bool $with_host): self
    {
        $this->with_host = $with_host;

        return $this;
    }

    public function getWithMaintenance(): ?bool
    {
        return $this->with_maintenance;
    }

    public function setWithMaintenance(bool $with_maintenance): self
    {
        $this->with_maintenance = $with_maintenance;

        return $this;
    }

    public function getStat(): ?string
    {
        return $this->stat;
    }

    public function setStat(string $stat): self
    {
        $this->stat = $stat;

        return $this;
    }

    public function getWithNewsletter(): ?bool
    {
        return $this->with_newsletter;
    }

    public function setWithNewsletter(bool $with_newsletter): self
    {
        $this->with_newsletter = $with_newsletter;

        return $this;
    }
}
