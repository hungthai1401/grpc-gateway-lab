## Build images

### gRPC server
```shell
cd ../server
cd server
docker build -t grpc-server:latest .
```

### gRPC gateway
```shell
cp proto ../gateway
cd gateway
docker build -t grpc-gateway:latest .
```

## Run containers
```shell
docker compose up
```