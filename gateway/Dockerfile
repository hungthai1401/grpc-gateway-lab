FROM golang:1.22-alpine AS builder

WORKDIR /app

RUN apk add --no-cache protobuf protobuf-dev git make

RUN go install google.golang.org/protobuf/cmd/protoc-gen-go@v1.31.0 && \
    go install google.golang.org/grpc/cmd/protoc-gen-go-grpc@v1.2.0 && \
    go install github.com/grpc-ecosystem/grpc-gateway/v2/protoc-gen-grpc-gateway@v2.18.1

COPY go.mod go.sum ./
RUN go mod download

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
RUN CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o gateway main.go

FROM alpine:3.19

WORKDIR /app
COPY --from=builder /app/gateway .

EXPOSE 8080
ENTRYPOINT ["/app/gateway"]