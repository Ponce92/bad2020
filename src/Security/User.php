<?php

namespace App\Security;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Rol;
use Doctrine\DBAL\Connection;
use App\Entity\SvaoProtected\Permiso;
use Symfony\Bridge\Doctrine\DependencyInjection\Security\UserProvider\EntityFactory;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity @Table(name="usuarios")
 */
class User  implements UserInterface
{

    /**
     * @ORM\Column(type='integer')
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length-100,unique=true)

     */
    private $username;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $password;


    private $roles = [];

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */

    private $idRol;

    private $aerolinea_id;

    private $aeropuerto_id;

    private $cliente_id;


    public function __construct(?int $rol,string $username, string $password,? int $aerolinea,?int $aeropuerto,?int $cliente )
    {
        if (empty($username))
        {
            throw new \InvalidArgumentException('No username provided.');
        }


        $this->username = $username;
        $this->password = $password;
        //aerolinea ?

        $this->aerolinea_id=  $aerolinea;
        $this->aeropuerto_id=  $aeropuerto;
        $this->cliente_id=$cliente;
        $this->idRol=$rol;
    }

    public function getCliente(): ?int
    {
        return $this->cliente_id;
    }

    public function setCliente(?Cliente $cliente):self
    {
        return $this;
    }

    public function getAerolinea(): ?int
    {

        return $this->aerolinea_id;
    }

    public function setAerolinea(?Aerolinea $aerolinea): self
    {
        $this->aerolinea = $aerolinea;

        return $this;
    }
    public function getAeropuerto():?int
    {
        return $this->aeropuerto_id;

    }


    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function hasPermission($str)
    {

//        $rol=$em->getRepository(Rol::class)->find($this->idRol);
//        foreach ($rol->getPermisos() as $pvt)
//        {
//            if($str==$pvt->getNombre())
//            {
//                return true;
//            }
//        }
//        return false;
    }
}

