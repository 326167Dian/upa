export const dashboardData = {
    monthlyRevenue: [
        {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }
    ],
    regionData: [
        {
            id: 'US-TX',
            name: 'Texas',
            value: 4447100
        },
        {
            id: 'US-GA',
            name: 'Georgia',
            value: 626932
        },
        {
            id: 'US-UT',
            name: 'Utah',
            value: 5130632
        },
        {
            id: 'US-NE',
            name: 'Nebraska',
            value: 5130632
        },
    ],
    overViewData: {
        duration: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        income: [3572, 4121, 6261, 4231, 1332, 1844, 2980, 3759, 3632, 5157, 3245, 3535],
        expense: [4555, 5232, 3812, 2486, 3319, 2643, 2111, 2046, 629, 831, 1525, 1088],
        sum: [
            {
                name: 'Total Earning',
                value: 43669
            },
            {
                name: 'Average Earning',
                value: 3639
            },
            {
                name: 'Total Expense ',
                value: 30277
            },
            {
                name: 'Average Expense',
                value: 2523
            }
        ]
    },
    recentTransactionData: [
        {
            transactionId: 135,
            name: 'Julio Baker',
            img: '/assets/images/avatars/thumb-1.jpg',
            status: 'Approved',
            date: 1583430400000,
            amount: 761
        },
        {
            transactionId: 138,
            name: 'Robert Mitchell',
            img: '/assets/images/avatars/thumb-2.jpg',
            status: 'Pending',
            date: 1582416000000,
            amount: 628
        },
        {
            transactionId: 115,
            name: 'David Powell',
            img: '/assets/images/avatars/thumb-3.jpg',
            status: 'Rejected',
            date: 1583107200000,
            amount: 47
        },
        {
            transactionId: 112,
            name: 'Christina Morrison',
            img: '/assets/images/avatars/thumb-4.jpg',
            status: 'Pending',
            date: 1579132800000,
            amount: 112
        },
        {
            transactionId: 108,
            name: 'Calvin Reid',
            img: '/assets/images/avatars/thumb-5.jpg',
            status: 'Approved',
            date: 1582416000000,
            amount: 86
        }
    ],
    recentRatingData: [
        {
            name: 'Devon Hughes',
            img: '/assets/images/avatars/thumb-6.jpg',
            review: 'My neighbor Georgie has one of these. She works as a busboy and she says it looks brown.',
            rating: 5,
            date: 1583107200000
        },
        {
            name: 'Tom Lucas',
            img: '/assets/images/avatars/thumb-7.jpg',
            review: 'The box this comes in is 5 kilometer by 5 inch and weights 13 kilogram!!!',
            rating: 3,
            date: 1582761600000
        },
        {
            name: 'Wade Jenkins',
            img: '/assets/images/avatars/thumb-8.jpg',
            review: 'I tried to impale it but got fudge all over it.',
            rating: 2,
            date: 1579219200000
        },
        {
            name: 'Kathy Barnes',
            img: '/assets/images/avatars/thumb-9.jpg',
            review: 'I will refer everyone I know.',
            rating: 5,
            date: 1584489600000
        }
    ],
    deviceStatisticData: {
        devices:[
            {
                device: 'Desktop',
                amount: 5882,
                percent: 25
            },
            {
                device: 'Tablet',
                amount: 3582,
                percent: 15
            },
            {
                device: 'Mobile',
                amount: 11582,
                percent: 50
            },
            {
                device: 'Other',
                amount: 1845,
                percent: 10
            }
        ],
        browser: [
            {
                browser: 'Chrome',
                percent: 50
            },
            {
                browser: 'Firefox',
                percent: 30
            },
            {
                browser: 'Edge',
                percent: 20
            },
        ]
    },
    countriesData: [
        {
            flag: '/assets/images/thumbs/us.png',
            country: 'United State',
            users: 936,
            percent: 30,
        },
        {
            flag: '/assets/images/thumbs/german.png',
            country: 'German',
            users: 743,
            percent: 25,
        },
        {
            flag: '/assets/images/thumbs/japan.png',
            country: 'Japan',
            users: 699,
            percent: 20,
        },
        {
            flag: '/assets/images/thumbs/italy.png',
            country: 'Italy',
            users: 328,
            percent: 15,
        },
        {
            flag: '/assets/images/thumbs/spain.png',
            country: 'Spain',
            users: 266,
            percent: 10,
        }
    ]
}