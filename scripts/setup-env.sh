#!/bin/bash

# default env
ENV=${1:-dev}

echo "Setting up environment: $ENV"

# mapování názvů
case $ENV in
  dev)
    BACKEND_ENV="dev"
    FRONTEND_ENV="development"
    ;;
  prod)
    BACKEND_ENV="prod"
    FRONTEND_ENV="production"
    ;;
  test)
    BACKEND_ENV="test"
    FRONTEND_ENV="test"
    ;;
  local)
    BACKEND_ENV="local"
    FRONTEND_ENV="local"
    ;;
  *)
    echo "Unknown environment: $ENV"
    exit 1
    ;;
esac

# Backend
BACKEND_SRC="backend/.env.${BACKEND_ENV}.example"
BACKEND_DEST="backend/.env.${BACKEND_ENV}"

if [ -f "$BACKEND_SRC" ]; then
  cp "$BACKEND_SRC" "$BACKEND_DEST"
  echo "Backend env created: $BACKEND_DEST"
else
  echo "Backend source not found: $BACKEND_SRC"
fi

# Frontend
FRONTEND_SRC="frontend/.env.${FRONTEND_ENV}.example"
FRONTEND_DEST="frontend/.env.${FRONTEND_ENV}"

if [ -f "$FRONTEND_SRC" ]; then
  cp "$FRONTEND_SRC" "$FRONTEND_DEST"
  echo "Frontend env created: $FRONTEND_DEST"
else
  echo "Frontend source not found: $FRONTEND_SRC"
fi

echo "Done."