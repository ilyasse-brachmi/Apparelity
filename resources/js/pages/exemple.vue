<script setup lang="ts">
import Product from "../../images/jacket.png"
import { LMap, LTileLayer, LMarker, LPolyline, LPopup, LCircleMarker, LTooltip } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import { ref } from "vue";
import { latLngBounds, latLng } from "leaflet";


const url = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
const attribution = '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors'
const zoom = ref(5)
const center = ref([47.413220, -1.219482])
const MarkerLatLang = [47.313220, -1.319482]
const MarkerLatLang5 = [63.03474055597919, 15.67606958969986]
const MarkerLatLang2 = [-33.21587333561651, -67.99031314110515]
const MarkerLatLang4 = [32.61607996163231, 108.14249839879659]
const MarkerLatLang3 = [55.225779252128476, -117.03328302613647]
const MarkerLatLang1 = [31.443669093644875, -4.241881509506873]
const bounds = latLngBounds([
	[40.70081290280357, -74.26963806152345],
	[40.82991732677597, -74.08716201782228]
])
const maxBounds = latLngBounds([
	[40.70081290280357, -74.26963806152345],
	[40.82991732677597, -74.08716201782228]
])
// function zoomUpdated (zoom) {
// 	console.log(zoom)
// 	zoom.value = zoom
// }

function centerUpdated (center) {
	center.value = center;
}

function boundsUpdated (bounds) {
	bounds.value = bounds;
}
</script>
<template lang="pug">
div(ref="mapContainer" class="h-full flex items-center justify-center")
	div(class="w-full h-full")
		LMap(:useGlobalLeaflet="false" ref="map" v-model:zoom="zoom" :center="MarkerLatLang1" :bounds="bounds" :maxBounds="maxBounds")
			LTileLayer(url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base" name="OpenStreetMap" :minZoom="2")
			LMarker(:latLng="MarkerLatLang1")
				LPopup(style="width: 10rem;")
					div(class="w-[10rem] h-[8rem]")
						div(class="flex items-center justify-start gap-2")
							div(class="w-16 h-16 rounded-full border-2 border-black overflow-hidden")
								img(:src="Product" class="w-16 rounded-full")
							h1(class="font-semibold text-xl") Arfoud
						p This is the Adress of the first Material
			LMarker(:latLng="MarkerLatLang")
			LMarker(:latLng="MarkerLatLang5")
			LCircleMarker(:latLng="MarkerLatLang5" :radius="17" :color="'orange'")
			LMarker(:latLng="MarkerLatLang2")
			LMarker(:latLng="MarkerLatLang4")
				LPopup(style="width: 10rem;")
					div(class="w-[10rem] h-[8rem]")
						div(class="flex items-center justify-start gap-2")
							div(class="w-16 h-16 rounded-full border-2 border-black overflow-hidden")
								img(:src="Product" class="w-16 rounded-full")
							h1(class="font-semibold text-xl") China
						p This is the Adress of the first Material
			LMarker(:latLng="MarkerLatLang3")
				LPopup(style="width: 10rem;")
					div(class="w-[10rem] h-[8rem]")
						div(class="flex items-center justify-start gap-2")
							div(class="w-16 h-16 rounded-full border-2 border-black overflow-hidden")
								img(:src="Product" class="w-16 rounded-full")
							h1(class="font-semibold text-xl") Canada
						p This is the Adress of the first Material
			LPolyline(:latLngs="[MarkerLatLang3, MarkerLatLang]" :color="'hsl(0, 100%, 50%)'" :lineCap="'butt'")
			LPolyline(:latLngs="[MarkerLatLang1, MarkerLatLang]" :color="'hsl(0, 100%, 50%)'" :lineCap="'butt'")
			LPolyline(:latLngs="[MarkerLatLang, MarkerLatLang2]" :color="'hsl(0, 100%, 50%)'" :lineCap="'butt'")
			LPolyline(:latLngs="[MarkerLatLang, MarkerLatLang5]" :color="'hsl(0, 100%, 30%)'" :lineCap="'butt'")
			LPolyline(:latLngs="[MarkerLatLang2, MarkerLatLang4]" :color="'hsl(0, 100%, 70%)'" :lineCap="'butt'")
</template>