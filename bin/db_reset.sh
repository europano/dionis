#!/usr/bin/env bash

#readonly BIN=$(dirname $(readlink -m $0))
readonly BIN=bin
readonly env=${SYMFONY_ENV:-dev}
[ ${env} != "dev" -a ${env} != "test" ] && echo ">>> Ce script ne doit être joué qu'avec SYMFONY_ENV=[dev ou test]" && exit 1

echo ">>> DB reset"
${BIN}/console doctrine:database:drop --force
${BIN}/console doctrine:database:create

${BIN}/console doctrine:migrations:migrate  --no-interaction
${BIN}/console doctrine:migrations:version -n --add --all

exit 0
echo ">>> suppression des fichiers des documents"
[ -d ${BIN}/../uploaded ] && rm -rf ${BIN}/../uploaded/*


