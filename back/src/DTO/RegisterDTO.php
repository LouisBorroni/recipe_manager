<?php
// src/DTO/RegisterDTO.php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterDTO
{
    /**
     * @Assert\Email(message="The email '{{ value }}' is not a valid email.")
     * @Assert\NotBlank(message="Email is required.")
     */
    public string $email;

    /**
     * @Assert\NotBlank(message="Pseudo is required.")
     * @Assert\Length(min=3, max=20, minMessage="Pseudo must be at least {{ limit }} characters long.", maxMessage="Pseudo cannot be longer than {{ limit }} characters.")
     */
    public string $pseudo;

    /**
     * @Assert\NotBlank(message="Password is required.")
     * @Assert\Length(min=8, minMessage="Password must be at least {{ limit }} characters long.")
     */
    public string $password;
}
