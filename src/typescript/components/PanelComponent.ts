import {Component, ComponentDefinition, State, Event} from "../vendor/nova/nova.js";
import {SportTerrain} from "../models/SportTerrain.js";
import {SportEvent} from "../models/SportEvent.js";
import {SportEventService} from "../services/SportEventService.js";

declare const he: any;

export class PanelComponent extends Component {
    public static readonly definition: ComponentDefinition = this.define("panel-component");
    @State private _sportTerrain?: SportTerrain;
    @State private _section: "info" | "events" = "info";
    private _events: SportEvent[] = [];

    @Event("click")
    public onInfoClick(): void {
        this._section = "info";
    }

    @Event("click")
    public onEventsClick(): void {
        this._section = "events";
    }

    public get sportTerrain() {
        return this._sportTerrain;
    }

    public set sportTerrain(sportTerrain: SportTerrain) {
        SportEventService.getListBySportTerrainId(Number(sportTerrain.id)).then((events: SportEvent[]): void => {
            this._events = events;
            this._sportTerrain = sportTerrain;
        });
    }

    public override render(): string {
        return `
            <div class="col-12 col-md-4 overflow-auto p-3 map-panel">
                ${this._sportTerrain ? this._renderPanel() : this._renderAlert()}
            </div>
        `;
    }

    private _renderAlert(): string {
        return `
            <div class="alert alert-warning text-center on-top" role="alert">
                Sélectionner un marqueur pour voir les événements
            </div>
        `;
    }

    private _renderPanel(): string {
        return `
            <div class="my-4">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button ${this.onInfoClick} class="nav-link on-top${this._section === "info" ? " active" : ""}">
                            Info
                        </button>
                    </li>
                    <li class="nav-item">
                        <button ${this.onEventsClick} class="nav-link on-top${this._section === "events" ? " active" : ""}">
                            Événements
                        </button>
                    </li>
                </ul>
                <hr class="on-top">
                <div>
                    ${this._section === "info" ? this._renderInfo() : this._renderEvents()}
                </div>
            </div>
        `;
    }

    private _renderInfo(): string {
        return `
            <table class="table table-responsive table-striped on-top">
                <tbody>
                    <tr>
                        <th scope="row">Type de terrain</th>
                        <td>${this._sportTerrain.terrain} - ${this._sportTerrain.type}</td>
                    </tr>
                    ${(this._sportTerrain.flooring === null ? "" : `        
                    <tr>
                        <th scope="row">Revêtement du sol</th>
                        <td>${this._sportTerrain.flooring}</td>
                    </tr>`)}
                    <tr>
                        <th scope="row">Municipalité</th>
                        <td>${this._sportTerrain.city}</td>
                    </tr>
                    ${(this._sportTerrain.address === null ? "" : `        
                    <tr>
                        <th scope="row">Adresse</th>
                        <td>${this._sportTerrain.address}</td>
                    </tr>`)}
                    ${(this._sportTerrain.parc === null ? "" : `        
                    <tr>
                        <th scope="row">Parc</th>
                        <td>${this._sportTerrain.parc}</td>
                    </tr>`)}
                    <tr>
                        <th scope="row">Longitude</th>
                        <td>${this._sportTerrain.longitude}</td>
                    </tr>
                    <tr>
                        <th scope="row">Latitude</th>
                        <td>${this._sportTerrain.latitude}</td>
                    </tr>
                    ${(this._sportTerrain.creation_date === null ? "" : `        
                    <tr>
                        <th scope="row">Date de création</th>
                        <td>${this._sportTerrain.creation_date}</td>
                    </tr>`)}
                    ${(this._sportTerrain.modification_date === null ? "" : `        
                    <tr>
                        <th scope="row">Date de modification</th>
                        <td>${this._sportTerrain.modification_date.substring(0, this._sportTerrain.modification_date.length - 3)}</td>
                    </tr>`)}
                </tbody>
            </table>
        `;
    }

    private _renderEvents(): string {
        function format(str: string): string {
            return he.decode(str.replace(/&amp;#039;&amp;#039;/g, "'"));
        }

        return `
            <div class='mb-3'>
                <a class="btn btn-secondary on-top w-100 fs-4 fw-bold" href="/views/add-event/?terrainId=${this._sportTerrain.id}">
                    <i class="fa-solid fa-plus"></i> 
                    Ajouter un événement
                </a>
                ${this._events.map((event: SportEvent): string => `
                    <a class="border rounded p-3 text-decoration-none text-black border border-2 mt-3 w-100 fw-bold d-flex justify-content-between align-items-center gap-3 flex-wrap event-button on-top bg-white text-break" href="/views/event/?id=${format(event.id)}">
                        <span>${format(event.organizer)} - ${format(event.event_name)}</span>
                        <span>${format(event.start_date)}</span>
                    </a>
                `).join("")}
                ${this._events.length === 0 ? `
                    <div class="alert alert-info mt-3 on-top text-center" role="alert">
                        Aucun événement n'est associé à ce terrain
                    </div>
                ` : ""}
            </div>
        `;
    }
}