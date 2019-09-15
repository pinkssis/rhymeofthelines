<?php
/**
 * Created by PhpStorm.
 * User: универ
 * Date: 19.03.2019
 * Time: 16:25
 */

namespace App\Controller;

use App\Entity\File;
use App\Entity\Line;
use App\Repository\LineRepository;
use Doctrine\DBAL\Types\TextType;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends AbstractController
{
  public function index(Request $request)
    {
        return $this->render('index.html.twig');
    }


    private $repo; /*почему не видит?*/

    public function __construct(LineRepository $repo)
    {
        $this->repo = $repo;
    }

    public function read(Request $request)
    {
        /** @var UploadedFile $data */
        $data = $request->files->get('f');
        $file = file($data->getRealPath());
        foreach ($file as $line)
        {
            $newLine = new Line($line);
            $this->repo->add($newLine);
        }
        $result = $this->getLines();

        shell_exec('php ' . __DIR__ . '/../../bin/console doctrine:schema:drop --force');
        shell_exec('php ' . __DIR__ . '/../../bin/console doctrine:schema:create ');

        return $this->render('rusult.html.twig', ['result' => $result]);
    }

    public function getAll()
    {
        /*return $this->render('example.html.twig', ['test' => 'test']);*/
        return new $this->json($this->repo->findAll());
    }

    public function getLines()
    {
        $lines = $this->repo->findAll();
        $oneline = array_rand($lines);
        $twoline = array_rand($lines);

        $a = $this->repo->findBy(['end'=> $lines[$oneline]->getEnd()]);
        $threeline = array_rand($a);

        $b = $this->repo ->findBy(['end'=> $lines[$twoline]->getEnd()]);
        $fourline = array_rand($b);


        return ['oneLine' => $lines[$oneline]->getString(), 'twoLine' =>$lines[$twoline]->getString(), 'threeLine' =>$a[$threeline]->getString(), 'fourLine' =>$b[$fourline]->getString()];
    }

    public function update(string $fileName)
    {
        $newLine = $this->repo->find( 1);
        $fh = fopen($fileName, 'r');
        $readLine = fget($fh);
        fclose($fh);
        $newLine->setString($readLine);
        $this->repo->add($newLine);
        return $this->json($newLine);
    }

    public function delete(Line $line)
    {
        $line = $this->repo->find(1);
        $this->repo->delete($line);
        return new Reponse();
    }

    /**
     *
     */

    /**public function getByPrice()
    {
        $product = $this->productRepository->getByPrice('500');

    }*/
}
