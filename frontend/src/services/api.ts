import axios from 'axios'

const API_URL = 'http://localhost/backend/calculate-distance.php'

interface Coordinates {
  latitude: number
  longitude: number
}

interface DistanceResult {
  meters: number
  kilometers: number
}

export const geoApi = {
  async calculateDistance(point1: Coordinates, point2: Coordinates): Promise<DistanceResult> {
    try {
      const response = await axios.post(API_URL, {
        point1,
        point2,
      })

      if (response.data.status === 'error') {
        throw new Error(response.data.message)
      }

      return response.data.data
    } catch (error) {
      console.error('API Error:', error)
      throw new Error('Nie udało się obliczyć odległości')
    }
  },
}
