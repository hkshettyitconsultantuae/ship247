import {Link} from "@inertiajs/react";
import dayjs from "dayjs";

const shortenText = (text,max) =>{
    return text && text.length > max ? text.slice(0,max).split(' ').slice(0, -1).join(' ') : text
}
const LatestNewsBox = ({news}) => {
    return <>
        <div className="news-inner-box latest-news">
            <figure className="lg:w-5/12">
                {news.image && <img style={{}} src={`/storage/${news.image}`} className="min-h-[300px]"/>}
            </figure>

            <article className="xl:w-6/12 lg:w-7/12">
                <div className="category">{news.category}</div>
                <h4 className="title">{news.title}</h4>
                <div className="date">{dayjs(news.published_date).format('DD MMM YYYY')}</div>
                <p className="detail">{shortenText(news.detail.replace( /(<([^>]+)>)/ig, ''), 150)+'...'}</p>
                <Link href={'/news/'+news.id} className="default-button red">Read More</Link>
            </article>
        </div>
    </>
}

export default LatestNewsBox;
