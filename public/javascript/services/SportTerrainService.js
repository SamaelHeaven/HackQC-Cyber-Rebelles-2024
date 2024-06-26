export class SportTerrainService {
    static async getById(id) {
        const response = await fetch("/api/sport-terrain-api.php?id=" + id);
        return response.json();
    }
    static async getList() {
        const response = await fetch("/api/sport-terrain-api.php?list=true");
        return response.json();
    }
}
