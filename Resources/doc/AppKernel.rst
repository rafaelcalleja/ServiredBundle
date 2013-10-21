- Edit %rootdir%/app/AppKernel.php
  and add the following bundle in the AppKernel::registerBundles() method:

    new RC\ServiredBundle\RCServiredBundle(),
