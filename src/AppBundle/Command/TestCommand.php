<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\News;
use AppBundle\Entity\Comment;

class TestCommand extends ContainerAwareCommand
{
    private $em;
    private $io;

    protected function configure()
    {
        $this
            ->setName('uppler:test:add_comment')
            ->setDescription('test command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->em = $this->getContainer()->get('doctrine')->getManager();

        $today = new \DateTime();

        /*$news = new News();
        $news->setTitle('Titre')
            ->setContent('Lorem ipsum et coetera...')
            ->setAuthor('Mathieu')
            ->setPublicationDate($today)
        ;

        $this->em->persist($news);*/

        $news = $this->em->getRepository('AppBundle:News')->find(2);

        $this->io->text($news->getCountComments().' commentaires');

        $comment = new Comment();
        $comment->setContent('C\'est de la merde')
            ->setAuthor('Emilien')
            ->setPublicationDate($today)
            ->setNews($news)
        ;

        $this->em->persist($comment);

        $this->em->flush();

        $this->io->text($news->getCountComments().' commentaires');
    }
}
