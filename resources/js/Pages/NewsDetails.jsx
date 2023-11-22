import dayjs from "dayjs";
import {Head, Link} from "@inertiajs/react";
import parse from 'html-react-parser'


const shortenText = (text,max) =>{
    return text && text.length > max ? text.slice(0,max).split(' ').slice(0, -1).join(' ') : text
}

const NewsDetails = ({news, news_prev, news_next}) => {
    return <>
        <Head title={news.title} />

        <section className="max-w-screen-4xl mx-auto">
            <div className="default-container mt-10">
                {news.image && <img style={{}} src={`/storage/${news.image}`}/>}

                <article className="news-inner-box inner-news">
                    <div className="lg:w-8/12 m-auto">
                        <div className="flex justify-between items-center">
                            <div className="w-8/12">
                                <h2 className="title">{news.title}</h2>
                            </div>
                            <div className="w-4/12 text-right">
                                <div className="date">{dayjs(news.published_date).format('DD MMM YYYY')}</div>
                            </div>
                        </div>

                        <p className="detail">
                            {parse(news.detail)}
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <section className="max-w-screen-4xl mx-auto">
            <div className="default-container mt-[120px] mb-[60px]">
                <div className="lg:w-8/12 m-auto">
                    <div className="news-detail-pagination grid md:grid-cols-2 gap-16">

                        <div className="prev">
                            {news_prev && <>
                                <h2 className="title">{news_prev.title}</h2>
                                <div className="flex justify-between">
                                    <Link href={'/news/'+news_prev.id} className="default-button red prev-button">prev Article</Link>
                                    <div className="date">{dayjs(news_prev.published_date).format('DD MMM YYYY')}</div>
                                </div>
                            </>}
                        </div>

                        <div className="next">
                            {news_next && <>
                                <h2 className="title">{news_next.title}</h2>
                                <div className="flex justify-between">
                                    <div className="date">{dayjs(news_next.published_date).format('DD MMM YYYY')}</div>
                                    <Link href={'/news/'+news_next.id} className="default-button red">next Article</Link>
                                </div>
                            </>}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </>;
}

export default NewsDetails;
