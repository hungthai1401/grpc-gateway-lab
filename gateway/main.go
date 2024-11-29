package main

import (
	"context"
	"log"
	"net/http"

	pb "gateway/proto"

	"github.com/grpc-ecosystem/grpc-gateway/v2/runtime"
	"google.golang.org/grpc"
	"google.golang.org/grpc/metadata"
)

func corsMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		w.Header().Set("Access-Control-Allow-Origin", "*")
		w.Header().Set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
		w.Header().Set("Access-Control-Allow-Headers", "Accept, Content-Type, Content-Length, Accept-Encoding, Authorization")

		if r.Method == "OPTIONS" {
			w.WriteHeader(http.StatusOK)
			return
		}

		next.ServeHTTP(w, r)
	})
}

func main() {
	ctx := context.Background()
	ctx, cancel := context.WithCancel(ctx)
	defer cancel()

	mux := runtime.NewServeMux(
		runtime.WithMetadata(func(ctx context.Context, req *http.Request) metadata.MD {
			return metadata.New(map[string]string{
				"content-type": "application/json",
			})
		}),
	)
	opts := []grpc.DialOption{grpc.WithInsecure()}

	// Register User service
	if err := pb.RegisterUserServiceHandlerFromEndpoint(ctx, mux, "grpc-server:50051", opts); err != nil {
		log.Fatalf("Failed to start User HTTP gateway: %v", err)
	}

	// Register Article service
	if err := pb.RegisterArticleServiceHandlerFromEndpoint(ctx, mux, "grpc-server:50051", opts); err != nil {
		log.Fatalf("Failed to start Article HTTP gateway: %v", err)
	}

	handler := corsMiddleware(mux)

	log.Println("Serving gRPC-Gateway on http://0.0.0.0:8080")
	if err := http.ListenAndServe(":8080", handler); err != nil {
		log.Fatalf("Failed to serve: %v", err)
	}
}
