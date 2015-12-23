<?php
/**
 * UploadAttachmentsCommand.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-15/12/23 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */
namespace Wiz\QiniuBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class UploadAttachmentsCommand
 * @package Wiz\QiniuBundle\Command
 */
class UploadAttachmentsCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('qiniu:upload:attachment')
            ->addArgument('bucket', InputArgument::REQUIRED, 'Upload Qiniu bucket name')
            ->setDescription('Upload web/uploads folder files to Qiniu');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $fs = $this->getContainer()->get('filesystem');
        $webPath = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        $uploadPath = $webPath . '/uploads';
        $client = $this->getContainer()->get('wiz_qiniu.client')->getBucket($input->getArgument('bucket'));

        if (!$fs->exists($uploadPath))
            throw new \RuntimeException(sprintf('The upload folder is not exist'));


        foreach ($finder->in($uploadPath) as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile()) {
                $key = str_replace($webPath, '', $file->getRealPath());
                $exifResult = $client->exif($key);
                if ($exifResult->response->code === 404) {
                    $uploadResult = $client->upload($file->getRealPath(), $key);
                    if (null === $uploadResult->error) {
                        $output->writeln(sprintf('<info>%s success</info>', $key));
                    } else {
                        throw new \RuntimeException($exifResult->error);
                    }
                } elseif ($exifResult->error !== null) {
                    throw new \RuntimeException($exifResult->error);
                } else {
                    $output->writeln(sprintf('<comment>%s exist</comment>', $key));
                }
            }
        }

        return 0;
    }

}