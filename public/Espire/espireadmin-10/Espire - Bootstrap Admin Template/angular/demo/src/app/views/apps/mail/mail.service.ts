import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpHeaders } from '@angular/common/http';
import { Mail } from './mail.interface';

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
    providedIn: 'root'
})
export class MailService {
    apiUrl = `/api/mail`;
 
    constructor(private http: HttpClient) {}
 
    getMail(value) {
        let params = new HttpParams();
        params = params.append('cat', value);
        return this.http.get<Array<Mail>>(this.apiUrl, {params: params})
    }

    deleteMail(ids) {
        let params = {
            ...httpOptions,
            body: {
                ids: ids
            }
        }
        console.log('params', params)
        return this.http.delete<Array<Mail>>(this.apiUrl, params)
    }

    updateMark(id: number, value: number) {
        let params = {
            id: id,
            mark: value
        }
        return this.http.post<Array<Mail>>(`${this.apiUrl}/mark`, params)
    }

    getMailContent(id) {
        let params = new HttpParams();
        params = params.append('id', id);
        return this.http.get<Mail>(`${this.apiUrl}/detail`, {params: params})
    }
}