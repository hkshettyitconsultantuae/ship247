import {Link} from "@inertiajs/react";
import dayjs from "dayjs";

const shortenText = (text,max) =>{
    return text && text.length > max ? text.slice(0,max).split(' ').slice(0, -1).join(' ') : text
}
const NewsBox = ({news}) => {
    return <>
        <div className="news-inner-box">
            <div className="flex justify-between">
                <div className="category">{news.category}</div>
                <div className="date">{dayjs(news.published_date).format('DD MMM YYYY')}</div>
            </div>
            <figure className="">
                {news.image && <img style={{}} src={`/storage/${news.image}`} className="min-h-[300px]"/>}
            </figure>

            <article className="">
                
                <h4 className="title">{shortenText(news.title.replace( /(<([^>]+)>)/ig, ''), 40)+'...'} </h4>
                
                <Link href={'/news/'+news.id} className="default-button red">Read More</Link>
            </article>
        </div>
    </>
}

export default NewsBox;
