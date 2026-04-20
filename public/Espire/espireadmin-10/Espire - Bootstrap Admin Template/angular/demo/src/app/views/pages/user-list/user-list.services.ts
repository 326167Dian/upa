import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

interface PersonalInfo {
    location: string,
    title: string,
    birthday: string,
    phoneNumber: string,
    facebook: string,
    twitter: string,
    instagram: string,
    site: string,
}

interface Users {
    id: string,
    name: string;
    email: string;
    img: string;
    role: string;
    lastOnline: number;
    status: string,
    personalInfo: PersonalInfo
}
 
@Injectable({
    providedIn: 'root'
})
export class UserListService {
    apiUrl = `/api/users`;
 
    constructor(private http: HttpClient) {}
 
    public getUsers() {
        return this.http.get<Array<any>>(this.apiUrl);
    }
}