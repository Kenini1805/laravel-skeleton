#!/usr/bin/env bash
cd laravel-base
git archive --format=zip HEAD `git diff $(git rev-list --max-parents=0 HEAD) HEAD --name-only` > ../skeleton.zip
cd ../..

