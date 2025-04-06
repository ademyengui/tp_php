<?php
class AttackPokemon {
    public $attackMinimal;
    public $attackMaximal;
    public $specialAttack;
    public $probabilitySpecialAttack;

    public function __construct($min, $max, $special, $probability) {
        $this->attackMinimal = $min;
        $this->attackMaximal = $max;
        $this->specialAttack = $special;
        $this->probabilitySpecialAttack = $probability;
    }
}

class Pokemon {
    protected $name;
    protected $imageUrl;
    protected $hp;
    protected $attackPokemon;
    protected $type = 'normal';

    public function __construct($name, $imageUrl, $hp, AttackPokemon $attack) {
        $this->name = $name;
        $this->imageUrl = $imageUrl;
        $this->hp = $hp;
        $this->attackPokemon = $attack;
    }

    public function isDead() {
        return $this->hp <= 0;
    }

    public function attack(Pokemon $target) {
        $damage = rand($this->attackPokemon->attackMinimal, $this->attackPokemon->attackMaximal);
        
        if (rand(1, 100) <= $this->attackPokemon->probabilitySpecialAttack) {
            $damage *= $this->attackPokemon->specialAttack;
        }
        
        $damage *= $this->getMultiplier($target->getType());
        $target->hp -= $damage;
        
        return $damage;
    }

    protected function getMultiplier($targetType) {
        return 1;
    }

    public function getType() {
        return $this->type;
    }

    public function whoAml() {
        return "{$this->name} ({$this->type}) - HP: {$this->hp}";
    }

    public function getName() {
        return $this->name;
    }

    public function getHp() {
        return $this->hp;
    }
}

class PokemonFeu extends Pokemon {
    protected $type = 'feu';
    
    protected function getMultiplier($targetType) {
        switch($targetType) {
            case 'plante': return 2;
            case 'feu':
            case 'eau': return 0.5;
            default: return 1;
        }
    }
}

class PokemonEau extends Pokemon {
    protected $type = 'eau';
    
    protected function getMultiplier($targetType) {
        switch($targetType) {
            case 'feu': return 2;
            case 'eau':
            case 'plante': return 0.5;
            default: return 1;
        }
    }
}

class PokemonPlante extends Pokemon {
    protected $type = 'plante';
    
    protected function getMultiplier($targetType) {
        switch($targetType) {
            case 'eau': return 2;
            case 'plante':
            case 'feu': return 0.5;
            default: return 1;
        }
    }
}


$flammeche = new AttackPokemon(15, 25, 2, 30);
$hydrocanon = new AttackPokemon(20, 30, 1.8, 25);
$fouetLianes = new AttackPokemon(10, 20, 2.5, 20);


$dracaufeu = new PokemonFeu('Dracaufeu', 'C:\xampp\htdocs\tp_php\pokemon\images\dracaufeu.png', 120, $flammeche);
$tortank = new PokemonEau('Tortank', 'C:\xampp\htdocs\tp_php\pokemon\images\tortank.jpg', 130, $hydrocanon);
$florizarre = new PokemonPlante('Florizarre', 'C:\xampp\htdocs\tp_php\pokemon\images\florizarre.png', 110, $fouetLianes);


function combat(Pokemon $p1, Pokemon $p2) {
    $tour = 1;
    
    while(!$p1->isDead() && !$p2->isDead()) {
        echo "<h3>Tour $tour</h3>";
        
        
        $degats = $p1->attack($p2);
        echo "{$p1->getName()} attaque → {$p2->getName()} (-$degats PV)<br>";
        echo $p2->whoAml()."<br><br>";
        
        if($p2->isDead()) break;
        
        
        $degats = $p2->attack($p1);
        echo "{$p2->getName()} contre-attaque → {$p1->getName()} (-$degats PV)<br>";
        echo $p1->whoAml()."<br><hr>";
        
        $tour++;
    }
    
    $vainqueur = $p1->isDead() ? $p2 : $p1;
    echo "<h2>Vainqueur : {$vainqueur->getName()} avec {$vainqueur->getHp()} PV restants!</h2>";
}


combat($dracaufeu, $tortank);
?>