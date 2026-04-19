<?php
    class Robot {
        public const MODELS = [
            'Sonny', 'Rosey', 'SICO', 'Data', 
            'Gort', 'Wall-E', 'Optimus Prime', 
            'Hal 9000', 'Twiki', 'Bender', 'Johnny 5'
        ];
        public const COLORS = [
            'Shiny', 'Chrome', 'Silver', 'Brass', 'Gold'
        ];
        public const OPERATING_SYSTEMS = [
            'Linux', 'Unix', 'SPARC', 'Binary', 'DOS', 'Tiny Hamsters'
        ];
        public const SIZES = [
            'Giant', 'Normal', 'Nano'
        ];

        public const IMAGES = [
            'sonny.jpg', 'rosey.jpg', 'sico.jpg', 'data.jpg',
            'gort.jpg', 'walle.jpg', 'optimus.webp',
            'hal9000.png', 'twiki.webp', 'bender.jpg', 'johnny5.jpg'
        ];

        public const LAWS = [
            'First', 'Second', 'Third'
        ];

        private $model;
        private $color;
        private $os;
        private $size;
        private $laws;
        private $image;

        public function __construct($model, $color, $os, $size, $laws) {
            $this->setModel($model);
            $this->setColor($color);
            $this->setOS($os);
            $this->setSize($size);

            $this->laws = array_fill(0, 3, false);
            foreach ($laws as $law) {
                $this->setLaw($law, true);
            }

            if (is_numeric($model)) {
                $index = intval($model);
            } else {
                $index = array_search($model, self::MODELS);
            }
            $this->setImage(self::IMAGES[$index]);
        }

        public function getModel(): string {
            return $this->model;
        }

        public function getColor(): string {
            return $this->color;
        }

        public function getOS(): string {
            return $this->os;
        }

        public function getSize(): string {
            return $this->size;
        }

        public function getLaw($num): bool {
            return $this->laws[$num];
        }

        public function getImage(): string {
            return $this->image;
        }

        // Sanity check the new data.
        // Prob could use enums but eh.
        private static function getConstVal($val, $consts): ?string {
            if (is_numeric($val)) {
                return $consts[intval($val)];
            }
            if (in_array($val, $consts)) {
                return $val;
            }
            return null;
        }

        public function setModel($model) {
            $val = self::getConstVal($model, self::MODELS);
            if (!is_null($val)) {
                $this->model = $val;
            }
        }

        public function setColor($color) {
            $val = self::getConstVal($color, self::COLORS);
            if (!is_null($val)) {
                $this->color = $val;
            }
        }

        public function setOS($os) {
            $val = self::getConstVal($os, self::OPERATING_SYSTEMS);
            if (!is_null($val)) {
                $this->os = $val;
            }
        }

        public function setSize($size) {
            $val = self::getConstVal($size, self::SIZES);
            if (!is_null($val)) {
                $this->size = $val;
            }
        }

        public function setLaw(int $num, bool $bool) {
            if ($num < 0 || $num >= count(self::LAWS)) {
                return;
            }
            $this->laws[$num] = $bool;
        }


        public function setImage($image) {
            //Lazy and not sanity checking this.
            $this->image = 'img/'.$image;
        }

        public function __toString() {
            $laws = [];
            for ($i = 0; $i < count(self::LAWS); $i++) {
                if ($this->getLaw($i)) {
                    $laws[] = self::LAWS[$i];
                }
            }
            switch (count($laws)) {
            case 1:
                $lawStr = ' and following the %s law of robotics';
                break;
            case 2:
                $lawStr = ' and following the %s and %s laws of robotics';
                break;
            case 3:
                $lawStr = ' and following the %s, %s, and %s laws of robotics';
                break;
            default:
                $lawStr = '';
                break;
            }
            $lawStr = sprintf($lawStr, ...$laws);

            return sprintf(
                '%s %s %s robot running %s%s',
                $this->getSize(),
                $this->getColor(),
                $this->getModel(),
                $this->getOS(),
                $lawStr
            );
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PopDroid!</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="navbar">
            <div>
                <a href="index.php" class="home-button nav-item" style="font-size:2.3ch">
                    <span style="font-weight:600">Pop</span>Droid!
                </a>
                <span style="width:100ch;position:relative;left:calc(50%-50ch)">
                    <a href="index.php" class="home-button nav-item">Home</a>
                    <a href="index.php" class="home-button nav-item">Products</a>
                    <a href="index.php" class="home-button nav-item">About</a>
                    <a href="index.php" class="home-button nav-item">Contact</a>
                </span>
            </div>
        </div>
        <div class="main-container">
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <div><a href="index.php">&lt; Back</a></div>
                <div>
                    <?php 
                        $args = [];
                        foreach (['MODELS', 'COLORS', 'OPERATING_SYSTEMS', 'SIZES'] as $property) {
                            if (!array_key_exists($property, $_POST)) {
                                die('Must provide data for the robot '.$property.'.');
                            }
                            $args[] = rawurldecode($_POST[$property]);
                        }
                        $laws = [];
                        for ($i = 0; $i < count(Robot::LAWS); $i++) {
                            if (array_key_exists('law'.$i, $_POST)) {
                                $laws[] = $i;
                            }
                        }
                        $args[] = $laws;

                        $robot = new Robot(...$args);
                    ?>
                    <div style="display:inline-block;width:calc(40% - 8ch);vertical-align:top;padding: 3ch 3ch">
                        <img src="<?=$robot->getImage()?>" style="width:100%;border:2px solid #68a;border-radius:1.5ch">
                    </div>
                    <div style="width:60%;display:inline-block;vertical-align:top;padding-top:3ch">
                        <h1>Order successful!</h1>
                        <p>Your <?=$robot?> has been ordered.</p>
                    </div>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div style="display:inline-block;width:calc(40% - 8ch);vertical-align:top;padding: 3ch 3ch">
                        <img src="img/atlas.webp" style="width:100%;border:2px solid #68a;border-radius:1.5ch">
                    </div>
                    <div style="width:60%;display:inline-block;vertical-align:top">
                        <div>
                            <?php 
                            $displayNames = ['Robot Model', 'Color', 'Operating System'];
                            foreach (['MODELS', 'COLORS', 'OPERATING_SYSTEMS'] as $i => $propertyName):?>
                                <div class="mid-lined" style="--color:#68a;--left:7.5ch;margin: 2ch 0 1ch 0"><b><?=$displayNames[$i]?></b></div>
                                <select name="<?=$propertyName?>">
                                    <?php foreach (constant('Robot::'.$propertyName) as $val):?>
                                        <option value="<?=rawurlencode($val)?>"><?=$val?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php endforeach ?>
                        </div>
                        <div class="mid-lined" style="--color:#68a;--left:7.5ch;margin: 2ch 0 1ch 0"><b>Robot Size</b></div>
                        <fieldset>
                            <?php foreach (Robot::SIZES as $size): ?>
                                <input type="radio" id="<?=rawurlencode($size)?>" name="SIZES" value="<?=rawurlencode($size)?>">
                                <label for="<?=rawurlencode($size)?>"><?=$size?></label><br>
                            <?php endforeach ?>
                        </fieldset>
                        <div class="mid-lined" style="--color:#68a;--left:7.5ch;margin: 2ch 0 1ch 0"><b>Ethics</b></div>
                        <div>
                            <?php foreach ([
                                'A robot may not injure a human being or, through inaction, allow a human being to come to harm.',
                                'A robot must obey the orders given to it by human being except where such orders would conflict with the First law.',
                                'A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.'
                            ] as $i => $law): ?>
                                <input type="checkbox" id='law<?=$i?>' name='law<?=$i?>' value="true">
                                <label for='law<?=$i?>'><?=$law?></label><br>
                            <?php endforeach ?>
                        </div>
                        <br>
                        <input type="submit" value="Submit" class="submit">
                    </div>
                </form>
            <?php endif ?>
        </div>
    </body>
</html>