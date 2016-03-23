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
use Wiz\QiniuBundle\Exception\RuntimeException;

/**
 * Class UploadAttachmentsCommand
 * @package Wiz\QiniuBundle\Command
 */
class UploadAttachmentsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('qiniu:upload:attachment')
            ->addArgument('bucket', InputArgument::REQUIRED, 'Upload Qiniu bucket name')
            ->setDescription('Upload web/uploads folder files to Qiniu');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new Finder();
        $fs = $this->getContainer()->get('filesystem');
        $webPath = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
        $uploadPath = $webPath . '/uploads';
        $client = $this->getContainer()->get('wiz_qiniu.client');
        $bucket = $input->getArgument('bucket');

        if (!$fs->exists($uploadPath))
            throw new \RuntimeException(sprintf('The upload folder is not exist'));


        foreach ($finder->in($uploadPath) as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile()) {
                $key = str_replace($webPath, '', $file->getRealPath());
                // 删除上传目录的前置/,避免出现两次反斜杠
                if (strpos($key, '/') === 0) {
                    $key = substr($key, 1);
                }
                try {
                    $client->stat($bucket, $key);
                    $output->writeln(sprintf('<comment>%s exist</comment>', $key));
                    continue;
                } catch (RuntimeException $e) {
                    switch ($e->getCode()) {
                        case 612:
                            $client->uploadFile($bucket, $file->getRealPath(), $key);
                            $output->writeln(sprintf('<info>%s success</info>', $key));
                            break;
                    }
                }
            }
        }

        return 0;
    }

}