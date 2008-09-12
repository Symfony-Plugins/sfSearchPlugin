
if [ `ls -lA | wc -l` -ne 1 ]
    then
        echo "Error: Directory not empty. You must initialize a sfSearch development environment on an empty directory."

        echo "You must delete these files:"
        ls -A

        exit 1;
    fi

echo "Checking out sfSearch platform..."
svn co http://svn.symfony-project.com/plugins/sfSearchPlugin/trunk search

echo "Creating symfony installation..."
mkdir symfony
cd symfony
symfony generate:project sfSearch
symfony generate:app frontend
cd plugins

echo "Checking out Propel 1.3..."
svn co http://svn.symfony-project.com/plugins/sfPropelPlugin/branches/1.3 sfPropelPlugin

echo "Linking search plugins..."
ln -s ../../search/core sfSearchPlugin
ln -s ../../search/lucene sfLucenePlugin
ln -s ../../search/solr sfSolrPlugin
ln -s ../../search/propel sfPropelSearchPlugin
ln -s ../../search/doctrine sfDoctrineSearchPlugin
ln -s ../../search/symfony sfSymfonySearchPlugin
ln -s ../../search/cached sfCachedSearchPlugin

echo "Creating skeleton..."
cd ..
symfony search:init-index SiteSearch
symfony search:init-interface frontend search SiteSearch

echo "Clearing cache..."
symfony cc

echo ""
echo "sfSearch development environment created.";

exit 0
