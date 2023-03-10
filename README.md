Parser Power
============
### Short description
Gamepedia extension for advanced lists parsing and more.

### Coding guidelines
New code should follow mediawiki coding style guidelines.

For now project php version on master is kept at `7.0.0`, but might get upgraded in the future.

You can verify Your code locally with composer using
`composer test`

**or** You can test it with docker script which will install everything for You and execute tests
[run-phpcs-in-docker.sh](run-phpcs-in-docker.sh)

### Branches
* `master` General development branch
* Cutout (release) branches
  * `REL1_39` compatible with MW 1.39 and is re-formatted with mediawiki coding standard
  * `REL1_37` compatible with MW 1.37 and older versions, uses old hydra-wiki coding standard

##### External resources
See [Parser Power Manual](https://help.fandom.com/wiki/Extension:ParserPower) for detailed instructions how to use this extension.

For more information please follow: [Parser Power extension on confluence](https://fandom.atlassian.net/wiki/spaces/PLAT/pages/2547515914/ParserPower)
