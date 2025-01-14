import { defineStore } from 'pinia'
import { ref } from 'vue'
import { geoApi } from '../services/api'

interface Coordinates {
  latitude: number
  longitude: number
}

interface Distance {
  meters: number
  kilometers: number
}

export const useGeoStore = defineStore('geo', () => {
  const point1 = ref<Coordinates>({ latitude: 52.237049, longitude: 21.017532 })
  const point2 = ref<Coordinates>({ latitude: 50.06465, longitude: 19.944981 })
  const distance = ref<Distance | null>(null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  async function calculateDistance() {
    loading.value = true
    error.value = null

    try {
      distance.value = await geoApi.calculateDistance(point1.value, point2.value)
    } catch (err) {
      error.value = 'Wystąpił błąd podczas obliczania odległości'
    } finally {
      loading.value = false
    }
  }

  return {
    point1,
    point2,
    distance,
    loading,
    error,
    calculateDistance,
  }
})
