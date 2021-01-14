# marketing.concretecms.com

This repo contains the code for the concretecms.com and concretecms.org marketing websites.

## Installation Instructions.

1. Clone this repo.
2. Install dependencies by running `composer install`.
3. Install concrete5, making sure to select the `concrete_cms_marketing` starting point. Here is an example of installation via the command line.

`concrete/bin/concrete5 c5:install -vvv --db-server=localhost --db-database=concrete_cms_marketing --db-username=user --db-password=password --starting-point=concrete_cms_marketing --admin-email=your@email.com --admin-password=password`
