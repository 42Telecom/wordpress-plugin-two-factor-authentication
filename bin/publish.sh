#!/bin/bash

#------------------------------------------------------------------------------#
#                                Publish.sh                                    #
#------------------------------------------------------------------------------#
# Name:
#
# A script to publish a Wordpress plugin from local git repository to the
# Wordpress SVN repository.
#
# Usage: sh publis.sh --login myLogin --password myPassord [--t thetag]
#
# -l or --login:    Login for the Wordpress SVN repository
# -p or --password: Password for the Wordpress SVN repository
# -t or --tag:      Git tag to use as build reference (optional, by default using the last tag)
#
# Author: Sebastien Lemarinel <sebastien.lemarinel@fortytwo.com>
# Company Fortytwo <https://www.fortytwo.com>
# Date: 2016/03/30
#------------------------------------------------------------------------------#

# Predefined values
# Colors for UI
CYAN='\033[0;36m'
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
NC='\033[0m'
# Dependencies
dependencies=("git" "svn")
dependenciesStatus=true
# Repository
REPOSITORY="https://plugins.svn.wordpress.org/fortytwo-two-factor-authentication/"
# Local svn repository directory
LOCALSVN="svn"

# Some fun
echo -e "${CYAN}
############################################
 ______         _         _
|  ____|       | |       | |
| |__ ___  _ __| |_ _   _| |___      _____
|  __/ _ \| '__| __| | | | __\ \ /\ / / _ \\
| | | (_) | |  | |_| |_| | |_ \ V  V / (_) |
|_|  \___/|_|   \__|\__, |\__| \_/\_/ \___/
                    __/ |
                   |___/
--------------------------------------------
         Local Git to Wordpress SVN
############################################
${NC}
"

# Check for required dependencies
echo "Checking for required dependencies..."

for i in "${dependencies[@]}"
do
    if hash $i 2>/dev/null; then
        echo -e "${GREEN}[OK] ${i} installed.${NC}"
    else
        echo -e "${RED}[NA] This script require to have ${i} installed.${NC}"
        dependenciesStatus=false
    fi
done

if [ "$dependenciesStatus" = false ] ; then
    echo -e "${RED}Dependencies missing.${NC}"
    exit 1
fi
echo -e "\n"

# Check parameters
echo -e "Checking parameters..."

# Get the options
TEMP=`getopt -o l:p:t:: --long login:,password:,tag:: -n 'publish.sh' -- "$@"`
eval set -- "$TEMP"


while true ; do
    case "$1" in
        -l|--login)
            case "$2" in
                "") shift 2 ;;
                *) LOGIN=$2 ; shift 2 ;;
            esac ;;
        -p|--password)
            case "$2" in
                "") shift 2 ;;
                *) PASSWORD=$2 ; shift 2 ;;
            esac ;;
        -t|--tag)
            case "$2" in
                "") TAG=false ; shift 2 ;;
                *) TAG=$2 ; shift 2 ;;
            esac ;;
        --) shift ; break ;;
        *) echo -e "${RED}Internal error!${NC}" ; exit 1 ;;
    esac
done

# Check for required parameters
if [ -z $LOGIN ] || [ -z $PASSWORD ] ; then
    echo -e "${RED}The following parameter(s) are missing: ${NC}"
    if [ -z $LOGIN ] ; then
        echo -e "${RED}- Login (-l or --login)${NC}"
    fi

    if [ -z $PASSWORD ] ; then
        echo -e "${RED}- Password  (-p or --password)${NC}"
    fi
else
    echo -e "${GREEN}[OK] parameters.${NC}"
fi

echo -e "\n"

# Check if the svn repository exist
# And create it if necessary
echo -e "Checking if a local SVN repo exist"

if [ ! -d "$LOCALSVN" ]; then
    echo -e "${YELLOW}[WW] Creating directory for the local svn repository.${NC}"
    mkdir $LOCALSVN;
fi

svn info $LOCALSVN
if [ $? = 1 ]; then
    svn co $REPOSITORY $LOCALSVN
    echo -e "${YELLOW}[WW] Creating the svn repository.${NC}"
fi

# Get the tag in param or the last tag from git repo

# Copy project files on svn directory

# Commit and tag the branch

# Push the change on Wordpress svn repository
