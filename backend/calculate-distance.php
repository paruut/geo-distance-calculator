<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class GeoCalculator {
    private const EARTH_RADIUS = 6371000;

    public function validateCoordinates(array $point): bool {
        return isset($point['latitude']) &&
               isset($point['longitude']) &&
               is_numeric($point['latitude']) &&
               is_numeric($point['longitude']) &&
               $point['latitude'] >= -90 &&
               $point['latitude'] <= 90 &&
               $point['longitude'] >= -180 &&
               $point['longitude'] <= 180;
    }

    public function calculateDistance(array $point1, array $point2): array {
        $lat1 = deg2rad($point1['latitude']);
        $lon1 = deg2rad($point1['longitude']);
        $lat2 = deg2rad($point2['latitude']);
        $lon2 = deg2rad($point2['longitude']);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat/2) * sin($deltaLat/2) +
             cos($lat1) * cos($lat2) *
             sin($deltaLon/2) * sin($deltaLon/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        $meters = self::EARTH_RADIUS * $c;
        
        return [
            'meters' => round($meters),
            'kilometers' => round($meters / 1000, 2)
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON data');
        }

        if (!isset($data['point1']) || !isset($data['point2'])) {
            throw new Exception('Missing coordinates data');
        }

        $calculator = new GeoCalculator();

        if (!$calculator->validateCoordinates($data['point1']) || 
            !$calculator->validateCoordinates($data['point2'])) {
            throw new Exception('Invalid coordinates format or values');
        }
 
        $result = $calculator->calculateDistance($data['point1'], $data['point2']);

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}