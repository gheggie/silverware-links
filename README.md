# SilverWare Links Module

[![Latest Stable Version](https://poser.pugx.org/silverware/links/v/stable)](https://packagist.org/packages/silverware/links)
[![Latest Unstable Version](https://poser.pugx.org/silverware/links/v/unstable)](https://packagist.org/packages/silverware/links)
[![License](https://poser.pugx.org/silverware/links/license)](https://packagist.org/packages/silverware/links)

Provides an links page for [SilverWare][silverware] apps, divided into a series of categories with links.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Issues](#issues)
- [Contribution](#contribution)
- [Maintainers](#maintainers)
- [License](#license)

## Requirements

- [SilverWare][silverware]

## Installation

Installation is via [Composer][composer]:

```
$ composer require silverware/links
```

## Usage

The module provides two pages ready for use within the CMS:

- `LinkPage`
- `LinkCategory`

Create a `LinkPage` as the top-level of your links section. Under the `LinkPage` you
may add `LinkCategory` pages as children to divide the page into a series
of categories. Then, as children of `LinkCategory`, add your `Link` components for individual links.

## Issues

Please use the [GitHub issue tracker][issues] for bug reports and feature requests.

## Contribution

Your contributions are gladly welcomed to help make this project better.
Please see [contributing](CONTRIBUTING.md) for more information.

## Maintainers

[![Colin Tucker](https://avatars3.githubusercontent.com/u/1853705?s=144)](https://github.com/colintucker) | [![Praxis Interactive](https://avatars2.githubusercontent.com/u/1782612?s=144)](https://www.praxis.net.au)
---|---
[Colin Tucker](https://github.com/colintucker) | [Praxis Interactive](https://www.praxis.net.au)

## License

[BSD-3-Clause](LICENSE.md) &copy; Praxis Interactive

[silverware]: https://github.com/praxisnetau/silverware
[composer]: https://getcomposer.org
[issues]: https://github.com/praxisnetau/silverware-links/issues
