export interface GateCheck {
  id: string
  airport_id: string
  gate_id: string
  gate_number: string
  audio_status: string
  dvr_status: string
  audio_tested: boolean
  video_status: string
  video_tested: boolean
  created_at: Date
  updated_at: Date
  audio_test_url: string
  video_test_url: string
  first_flight_verified: boolean
  flights_started_time: string
  flights_ended_time: string
  flight_count: number
}
