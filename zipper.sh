#!/usr/bin/env bash
cd laravel-base
git archive --format=zip HEAD `git diff HEAD^ HEAD --name-only` > ../skeleton.zip
cd ../..

