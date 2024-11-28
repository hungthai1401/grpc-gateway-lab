FROM golang:1.22

WORKDIR /app

RUN apt-get update && apt-get install -y protobuf-compiler

COPY go.mod go.sum ./
RUN go mod download

RUN go install google.golang.org/protobuf/cmd/protoc-gen-go@v1.31.0
RUN go install google.golang.org/grpc/cmd/protoc-gen-go-grpc@v1.2.0
RUN go install github.com/grpc-ecosystem/grpc-gateway/v2/protoc-gen-grpc-gateway@v2.18.1

RUN mkdir -p /app/proto/google/api
COPY proto/ /app/proto/

RUN protoc -I/app/proto \
    --go_out . \
    --go_opt=module=gateway \
    --go-grpc_out . \
    --go-grpc_opt=module=gateway \
    --grpc-gateway_out . \
    --grpc-gateway_opt=module=gateway \
    /app/proto/*.proto

COPY *.go ./
RUN go build -o gateway main.go

ENTRYPOINT ["/app/gateway"]