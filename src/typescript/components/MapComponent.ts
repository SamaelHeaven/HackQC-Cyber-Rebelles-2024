import {Component, ComponentDefinition} from "../vendor/nova/nova.js";
import {SportTerrain} from "../models/SportTerrain.js";
import {CyclePath} from "../models/CyclePath.js";
import {SportTerrainService} from "../services/SportTerrainService.js";
import {CyclePathService} from "../services/CyclePathService.js";
import {PanelComponent} from "./PanelComponent.js";
import {HomeComponent} from "./HomeComponent.js";

declare const L: any;

export class MapComponent extends Component {
    public static readonly definition: ComponentDefinition = this.define("map-component");
    private _sportTerrains: SportTerrain[];
    private _cyclePaths: CyclePath[];
    private _map: any;
    private _markers: any;
    private _homeComponent: HomeComponent;

    public override async onInit(): Promise<void> {
        const [sportTerrains, cyclePaths] = await Promise.all([
            SportTerrainService.getList(),
            CyclePathService.getList()
        ]);
        this._sportTerrains = sportTerrains;
        this._cyclePaths = cyclePaths;
        this._homeComponent = this.queryComponent(HomeComponent.definition.tag);
    }

    public override onAppear(): void {
        this.shouldUpdate = false;
        this._initMap();
        this._initMarkers();
        this._displaySportTerrains();
        this._displayCyclePaths();
        this._homeComponent.loaded = true;
    }

    public override render(): string {
        return `
            <div class="col-12 col-md-8 p-0 map-container">
                <div id="map" class="w-100 h-100 map"></div>
                <div class="map-legend bg-light rounded border shadow p-2">
                    <h2 class="fs-5 text-center">Légende</h2>
                    <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <div class="sport-terrain-legend"></div>
                        <span>Terrain sportif</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <div class="cycle-path-legend"></div>
                        <span>Piste cyclable</span>
                    </div>
                </div>
            </div>
        `;
    }

    private async _onSportTerrainClick(id: number): Promise<void> {
        const panelComponent: PanelComponent = this.queryComponent(PanelComponent.definition.tag);
        if (panelComponent) {
            panelComponent.sportTerrain = await SportTerrainService.getById(id);
        }
    }

    private _initMap(): void {
        this._map = L.map('map').setView([45.751258, -73.442155], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this._map);
    }

    private _initMarkers(): void {
        this._markers = L.markerClusterGroup({
            disableClusteringAtZoom: 12,
            spiderfyOnMaxZoom: false,
            showCoverageOnHover: false,
            iconCreateFunction: function (cluster) {
                let count: number = 0;
                for (const marker of cluster.getAllChildMarkers()) {
                    if (marker.sportTerrain) {
                        count++;
                    }
                }
                return L.divIcon({
                    html: '<b>' + count + '</b>',
                    className: 'p-2 w-auto h-auto text-center rounded-circle map-cluster-icon border shadow',
                });
            }
        });
    }

    private _displaySportTerrains(): void {
        for (const sportTerrain of this._sportTerrains) {
            const marker = new L.Marker([sportTerrain.latitude, sportTerrain.longitude]);
            marker.bindPopup(sportTerrain.type);
            marker.on('click', (): void => {
                this._onSportTerrainClick(Number(sportTerrain.id)).then();
            });

            marker.sportTerrain = true;
            if (Number(sportTerrain.nb_events) > 0) {
                const numberMarker = L.marker([sportTerrain.latitude, sportTerrain.longitude], {
                    icon: L.divIcon({
                        className: 'custom-icon',
                        html: `<div class=\"bg-danger text-center rounded-circle text-white border border-black border-2 fw-bold\">${sportTerrain.nb_events}</div>`,
                        iconAnchor: [-5, 50],
                        iconSize: [20, 20]
                    })
                });

                this._markers.addLayer(numberMarker);
            }

            this._markers.addLayer(marker);
        }

        this._map.addLayer(this._markers);
    }

    private _displayCyclePaths(): void {
        for (const cyclePath of this._cyclePaths) {
            const coordinates = JSON.parse(cyclePath.coordinates_json);
            const geoJsonFeature: object = {
                type: 'Feature',
                geometry: {
                    type: cyclePath.type,
                    coordinates: coordinates
                }
            };

            const geoJson: string = JSON.stringify(geoJsonFeature);
            L.geoJSON(JSON.parse(geoJson), {
                style: (): object => {
                    return {
                        color: "green",
                        weight: 3
                    };
                }
            }).addTo(this._map);
        }
    }
}