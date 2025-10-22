# Rendre Joomla! CLI-ing

Ce dépôt contient le code de mon atelier sur le développement d'un plugin console pour Joomla! 5 au [JoomlaDay US
2025](https://jdayusa.com) intitulé : **Rendre Joomla! CLI-ing**.

Lors de cette session, j'ai démontré comment développer un plugin console pour Joomla! qui récupère des informations de la base de données et
les affiche dans la console.

Cette session a suivi la structure de mon livre sur le développement d'extensions pour Joomla! 5 intitulé _[Développer des extensions pour
Joomla! 5](https://developingextensionsforjoomla5.com/?utm_source=gh-jdusa25)_

[![Couverture du livre 'Développer des extensions pour Joomla!
5'](https://developingextensionsforjoomla5.com/images/cover.webp)](https://developingextensionsforjoomla5.com/)

## Télécharger la présentation PDF

- [Rendre Joomla! CLI-ing](https://carcam.github.io/make-joomla-cli-ing/slides/make-joomla-cli-ing.pdf)

## Comment utiliser ce dépôt

### Code du plugin

Le code du composant est situé dans la branche _main_ de ce dépôt et est organisé par les balises suivantes, reflétant
les différentes étapes de ma session :

- **v1.0.0**: C'est la version finale du plugin.

### Fichiers de présentation

Les fichiers de présentation sont situés dans la branche _slides_ de ce dépôt, spécifiquement dans le dossier `slides`.

La présentation a été créée à l'aide de [Marp](https://marp.app/), et les fichiers source sont situés dans le dossier `slides/src`.

La commande pour générer la présentation avec _Marp-cli_ est :

```bash
cd slides/src &&  marp --pdf ./make-joomla-cli-ing.md  --theme-set ./book.css --output ../make-joomla-cli-ing.pdf --allow-local-file
```

Et le PDF sera dans le dossier `slides` du dépôt.

### Données de maquette

Je fournis des données de maquette que vous pouvez importer dans votre base de données. Elles sont disponibles en trois formats différents :

-`generic.sql`: Ce fichier peut être facilement importé dans votre base de données, il suffit de remplacer le préfixe de table générique dans la commande `insert`
par celui de votre base de données.
- `ddev.sql`: Ce fichier peut être importé directement dans votre site DDEV.
- `import.csv`: Ce fichier peut être importé avec PhpMyAdmin ou tout autre outil similaire capable d'importer un fichier CSV dans une
table de base de données.

## Configurer un environnement de développement

Pour configurer un environnement de développement, suivez ces instructions :

1. Installez la dernière version de Joomla! dans votre environnement de développement préféré.
1. Ensuite, installez le composant principal à partir de ce lien.
1. Enfin, vous pouvez ajouter des tâches dans l'administrateur Joomla! ou importer celles du dossier Mockup data de ce dépôt.

### Configuration avec DDEV

Si vous utilisez [DDEV](https://ddev.com/) comme solution de développement local, vous pouvez utiliser ces commandes pour configurer votre environnement :

#### 1. Configuration de DDEV pour Joomla!

```bash
mkdir jdayusa25 && cd jdayusa25
```

```bash
curl -o joomla.zip -L $(curl -sL https://api.github.com/repos/joomla/joomla-cms/releases/latest | docker run -i --rm ddev/ddev-utilities jq -r '.assets | map(select(.name | test("^Joomla.*Stable-Full_Package\\.zip$")))[0].browser_download_url')
```

```bash
unzip joomla.zip && rm -f joomla.zip
```

```bash
ddev config --project-type=php --webserver-type=apache-fpm --upload-dirs=images
```

```bash
ddev start
```

```bash
ddev php installation/joomla.php install --site-name="Make Joomla! CLI-ing" --admin-user="Administrator"
--admin-username=admin --admin-password=AdminAdmin1! --admin-email=admin@example.com --db-type=mysql --db-encryption=0
--db-host=db --db-user=db --db-pass="db" --db-name=db --db-prefix=ddev_ --public-folder=""
```

#### 2. Installer le composant principal via CLI

```bash
ddev php cli/joomla.php extension:install --url=https://github.com/carcam/Unlock-the-Power-of-Joomla-5/releases/download/5-api/com_ctl.zip
```

#### 3. Charger les données de maquette dans la base de données

```bash
wget https://raw.githubusercontent.com/carcam/make-joomla-cli-ing/refs/heads/main/mockup-data/ddev.sql -O tasks.sql
```

```bash
ddev import-db --file=tasks.sql --no-drop
```